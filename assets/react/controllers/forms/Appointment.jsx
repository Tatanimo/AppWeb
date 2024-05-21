import axios from 'axios';
import React, {useEffect, useState} from 'react'
import Select from 'react-select';
import Professional from '../calendar/Professional'

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

    useEffect(() => {
        fetchAllowedAnimals(id, professional.id)
        .then(res => {
            let selectables = [];
            res.forEach(animal => {
                const select = {
                    "value": animal.fk_category,
                    "label": animal.name
                };
                selectables.push(select);
            });
            setOptions(selectables)
        })
        .catch(err => console.error(err));
    }, [])

  return (
    <section id="form-appointment">
        <div className='flex flex-col items-center'>
            <p className="font-ChunkFive text-3xl pr-4 self-start">pour garder :</p>
            <Select closeMenuOnSelect={false} menuPosition="fixed" value={selectedAnimals} onChange={setSelectedAnimals} isMulti options={options} className='mt-1 basic-multi-select w-full' classNamePrefix="select" id="select-animals" name="select-animals" />
        </div>
        <br />
        <div className='flex flex-col items-center'>
            <p className="font-ChunkFive text-3xl pr-4 self-start">selectionner une date :</p>
            <Professional id={professional.id} userId={id} appointment={true}/>
        </div>
    </section>
  )
}
