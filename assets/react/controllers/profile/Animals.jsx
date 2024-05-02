import React, { useEffect, useState } from 'react'
import AddAnimal from './AddAnimal'
import ProfileImages from '../images/ProfileImages'
import UpdateAnimal from './UpdateAnimal';
import axios from 'axios';
import datetimeDifference from 'datetime-difference';

async function fetchAnimals(){
    let response;
    await axios.get('/ajax/animal/user', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => response = res.data)
    return response;
}

async function fetchAnimal(id) {
    let response;
    await axios.get(`/ajax/animal/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    }).then(res => response = res.data);
    return response;
}

function age(difference){
    let num = null;
    let date = null;

    if (difference.years > 0) {
        num = difference.years;
        date = num > 1 ? "ans" : "an";
    } else if (difference.months > 0) {
        num = difference.months;
        date = "mois";
    } else if (difference.days > 0) {
        num = difference.days;
        date = num > 1 ? "jours" : "jour";
    }

    return `${num} ${date}`;
}

function Animals() {
    const [animals, setAnimals] = useState([]);
    const [fetchById, setFetchById] = useState(null);

    useEffect(() => {
        fetchAnimals().then(res => setAnimals(res));
    }, []);

    useEffect(() => {
        if (Number.isInteger(fetchById)) {
            fetchAnimal(fetchById)
            .then(res => {
                const isUpdating = animals.find((e) => {
                    return e.id === fetchById;
                })

                isUpdating ? setAnimals(animals.map(animal => {
                    return animal.id === fetchById ? res : animal
                })) : setAnimals([...animals, res]);
            })
            .finally(setFetchById(null));
        }
    }, [fetchById])

    return (
        <>
        {animals.map((e, i) => {
            console.log(e)
            const today = new Date();
            const birthdate = new Date(e.birthdate);
            const difference = datetimeDifference(birthdate, today);

            return (
                <div key={e.id} id="animal-card" className="border border-black rounded-lg h-96 flex p-4 m-4">
                    <div className="mx-6 min-w-64 max-w-64 content-center" id="animal-img">
                        <ProfileImages animalId={e.id} images={e.images}  />
                    </div>
                    <div id="animal-content" className="w-full">
                        <h2 className="font-ChunkFive text-4xl capitalize">{e.name}</h2>
                        <h2 className="font-ChunkFive text-4xl">{age(difference)}</h2>
                        <br/>
                        <p className="text-lg">{e.description}</p>
                    </div>
                    <div id="animal-setting" className="min-w-20 max-w-20 flex flex-col justify-end ml-4">
                        <UpdateAnimal animalId={e.id} setFetchById={setFetchById} />
                    </div>
                </div> 
            );
        })}
        <div className="flex justify-end mt-4" id="add-animal">
            <AddAnimal setFetchById={setFetchById} />
        </div>
    </>
  )
}

export default Animals