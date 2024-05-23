import axios from 'axios';
import React, {useEffect, useState} from 'react'
import Select from 'react-select';
import Professional from '../calendar/Professional'
import datetimeDifference from 'datetime-difference';
import { Spinner } from 'flowbite-react';
import Requirement from '../alerts/Requirement';
import { endpoint } from '../../../config';

async function fetchAllowedAnimals(idUser, idPro){
    let response;
    await axios.get(`/ajax/animals/${idUser}/${idPro}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => response = res.data);
    return response;
}

export default function Appointment({id, professional}) {
    const [selectedAnimals, setSelectedAnimals] = useState([]);
    const [options, setOptions] = useState([]);
    const [dateSelected, setDateSelected] = useState([]);
    const [loading, setLoading] = useState(false);
    const [requirements, setRequirements] = useState([]);

    useEffect(() => {
        fetchAllowedAnimals(id, professional.id)
        .then(res => {
            let selectables = [];
            res.forEach(animal => {
                const select = {
                    "value": animal.fk_category,
                    "label": animal.name,
                    "animal": animal
                };
                selectables.push(select);
            });
            setOptions(selectables)
        })
        .catch(err => console.error(err));
    }, []);

    const handleForm = () => {
        let arrayRequirements = [];

        if (dateSelected.length == 0) {
            arrayRequirements.push("Sélectionner une date");
        }

        if (selectedAnimals.length == 0) {
            arrayRequirements.push("Sélectionner un animal");
        }

        if (arrayRequirements.length > 0) {
            setRequirements(arrayRequirements);
            return false;
        }
        else {
            setRequirements([]);
            return true;
        }
    }

    const onSubmit = () => {
        if (handleForm()) {
            setLoading(true);
            const animals = selectedAnimals.map(e => e.animal);
            const appointment = {
                date: dateSelected,
                animals: animals,
                price: professional.price * calculDaysSelected(),
            };
            return accessing(professional.user.id, appointment);
        }
    }

    const accessing = async (contactId, appointment) => {
        await axios.post(`/ajax/messages`, {
            'contact': contactId,
            'appointment': appointment
        }, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then((response) => {
            window.location.replace(`${endpoint.base}/messages/${response.data}`);
        })
        .catch((err) => console.error(err))
        .finally(() => setLoading(false)); 
    }

    const calculDaysSelected = () => {
        const d = new Date(dateSelected[0]);
        const x = new Date(dateSelected[1])
        const t = datetimeDifference(d, x);
        t.days++;
        return parseInt(t.days);
    }

  return (
    <section id="form-appointment">
        {requirements.length > 0 ? (<Requirement requirements={requirements} />) : null}
        <div className='flex flex-col items-center'>
            <p className="font-ChunkFive text-3xl pr-4 self-start">pour garder :</p>
            <Select closeMenuOnSelect={false} menuPosition="fixed" value={selectedAnimals} onChange={setSelectedAnimals} isMulti options={options} className='mt-1 basic-multi-select w-full' classNamePrefix="select" id="select-animals" name="select-animals" />
        </div>
        <br />
        <div className='flex flex-col items-center'>
            <p className="font-ChunkFive text-3xl pr-4 self-start">selectionner une date :</p>
            <Professional id={professional.id} userId={id} appointment={true} onDateSelected={setDateSelected}/>
        </div>
        <br />
        {dateSelected.length > 0 ? (
            <div className='flex items-center'>
                <p className="font-ChunkFive text-3xl pr-4 self-start">prix :</p>
                <p className="font-ChunkFive text-3xl pr-4 self-start">{professional.price * calculDaysSelected()}<span>€</span></p>
            </div>

        ) : null}
        <br />
        {loading ? (
            <Spinner className="m-auto h-10 w-10 float-right text-blue-purple"/>
        ) : (
            <button type="button" onClick={() => onSubmit()} className='float-right inline-block active:scale-95 hover:bg-blue-purple-hover transition font-ChunkFive text-white text-lg bg-blue-purple px-5 py-3 rounded-xl uppercase'>Contacter</button>
        )}
    </section>
  )
}
