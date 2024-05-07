import React, { useEffect, useRef, useState } from 'react'
import CitiesInput from './CitiesInput'
import { DateRangePicker, Datepicker } from 'flowbite-datepicker';
import fr from 'flowbite-datepicker/locales/fr';
import Select from 'react-select';
import axios from 'axios';
import { Spinner } from 'flowbite-react';

async function fetchAnimals(){
    let response;
    await axios.get('/ajax/animal/user', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => response = res.data);
    return response;
}

async function fetchProfessionalsInAreaAndService(service, idCity, area){
    let response;
    await axios.get(`/ajax/users/${service}/${idCity}/${area}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => response = res.data)
    return response;
}

export default function SearchPetsitter({onPetsitters}) {
    const [selectedAnimals, setSelectedAnimals] = useState([]);
    const [options, setOptions] = useState([]);
    const [city, setCity] = useState({});
    const [radius, setRadius] = useState(0);
    const [isLoading, setIsLoading] = useState(false);

    useEffect(() => {
        const dateRangePickerEl = document.getElementById('dateRangePickerId');
        Object.assign(Datepicker.locales, fr);
        new DateRangePicker(dateRangePickerEl, {
            format: 'dd/mm/yyyy',
            language: 'fr',
            minDate : new Date(Date.now() + 86400000),
        }); 

        fetchAnimals().then(res => {
            let selectables = [];
            res.forEach(animal => {
                const select = {
                    "value": animal.id,
                    "label": animal.name
                };
                selectables.push(select);
            });
            setOptions(selectables);
        });
    }, []);

    const handleForm = () => {
        setIsLoading(true);
        fetchProfessionalsInAreaAndService("petsitter", city.id, radius)
        .then(res => {onPetsitters(res), console.log(res)})
        .catch(err => console.error(err))
        .finally(() => setIsLoading(false));
    }
    
  return (
    <form>
        <span className="font-ChunkFive text-3xl">Je recherche quelqu'un du :</span>
        <div className="mt-6">
            <div className="flex items-center" id="dateRangePickerId">
                <div className="relative w-1/2">
                    <input name="start" type="text" className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date de début" />
                    <div className="absolute inset-y-0 end-0 flex items-center pe-3 pointer-events-none">
                        <svg className="w-4 h-4 text-black dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                </div>
                <span className="mx-4 text-black font-ChunkFive text-3xl">au</span>
                <div className="relative w-1/2">
                    <div className="absolute inset-y-0 end-0 flex items-center pe-3 pointer-events-none">
                        <svg className="w-4 h-4 text-black dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input name="end" type="text" className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date de fin" />
                </div>
            </div>
        </div>
        <br />
        <div className='flex'>
            <div className='flex'>
                <span className="font-ChunkFive text-3xl mr-6">aux environs de :</span>
                <CitiesInput onCitySelect={setCity} />
            </div>
            <div className='flex'>
                <span className="font-ChunkFive text-3xl mx-6">dans un rayon de :</span>
                <div className='flex bg-[#EEF0F4] items-center pl-4 rounded-2xl overflow-hidden'>
                    <input onChange={(e) => setRadius(parseInt(e.target.value))} type='number' name="radius-of" className='bg-inherit text-xl w-16 border-none' id="radius-of" />
                    <span className='pr-4 text-xl'>km</span>
                </div>
            </div>
        </div>
        <br />
        <div className='flex items-center'>
            <span className="font-ChunkFive text-3xl pr-4">pour garder :</span>
            <Select value={selectedAnimals} onChange={setSelectedAnimals} isMulti options={options} className='basic-multi-select w-1/2' classNamePrefix="select" id="select-animals" name="select-animals" />
        </div>
        <br />
        <div className='flex justify-end'>
            {isLoading ? (
                <>
                    <Spinner className={`w-16 h-auto fill-blue-purple`} />
                </>
            ) : (
                <button onClick={handleForm} type='button' className={`inline-block justify-center active:scale-95 hover:bg-blue-purple-hover transition font-ChunkFive text-white text-xl bg-blue-purple px-7 py-5 rounded-xl uppercase`}>Rechercher</button>
            )}
        </div>
    </form>
  )
}
