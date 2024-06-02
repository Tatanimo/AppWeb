import React, { useEffect, useRef, useState } from 'react'
import CitiesInput from './CitiesInput'
import { DateRangePicker, Datepicker } from 'flowbite-datepicker';
import fr from 'flowbite-datepicker/locales/fr';
import Select from 'react-select';
import axios from 'axios';
import { Spinner } from 'flowbite-react';

async function fetchAnimals(id){
    let response;
    await axios.get(`/ajax/animal/user/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => response = res.data);
    return response;
}

async function fetchProfessionalsInAreaAndService(service, idCity, area, date, selectedAnimals){
    let response;
    await axios.get(`/ajax/professionals/${service}/${idCity}/${area}`, {
        params: {
            startDate: date[0],
            endDate: date[1],
            selectedAnimals: JSON.stringify(selectedAnimals)
        },
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => response = res.data)
    return response;
}

export default function SearchPetsitter({id, onPetsittersFound}) {
    const [selectedAnimals, setSelectedAnimals] = useState([]);
    const [options, setOptions] = useState([]);
    const [city, setCity] = useState({});
    const [radius, setRadius] = useState(0);
    const [isLoading, setIsLoading] = useState(false);
    const startDate = useRef();
    const endDate = useRef();

    useEffect(() => {
        const dateRangePickerEl = document.getElementById('dateRangePickerId');
        Object.assign(Datepicker.locales, fr);
        new DateRangePicker(dateRangePickerEl, {
            format: 'dd/mm/yyyy',
            language: 'fr',
            minDate : new Date(Date.now() + 86400000),
        }); 

        if(id){
            fetchAnimals(id).then(res => {
                let selectables = [];
                res.forEach(animal => {
                    const select = {
                        "value": animal.fk_category,
                        "label": animal.name
                    };
                    selectables.push(select);
                });
                setOptions(selectables);
            });
        }
    }, []);

    const handleForm = () => {
        if (startDate.current.value != null && endDate.current.value != null) {
            const startArray = startDate.current.value.split('/');
            const endArray = endDate.current.value.split('/');
            const start = new Date(startArray[2], startArray[1] - 1, startArray[0]);
            const end = new Date(endArray[2], endArray[1] - 1, endArray[0]);

            if (!isNaN(start) && !isNaN(end) && id ? selectedAnimals.length > 0 : true) {
                const transformedSelectedAnimals = selectedAnimals.map(item => item.value);
                setIsLoading(true);
                fetchProfessionalsInAreaAndService("petsitter", city.id, radius, [start, end], transformedSelectedAnimals)
                .then(res => res.length == 0 ? onPetsittersFound("not found") : onPetsittersFound(res))
                .catch(err => onPetsittersFound("not found"))
                .finally(() => setIsLoading(false));
            }
        }
    }

  return (
    <form>
        <span className="font-ChunkFive text-3xl">Je recherche quelqu'un du :</span>
        <div className="mt-6">
            <div className="flex items-center" id="dateRangePickerId">
                <div className="relative w-1/2">
                    <input name="start" ref={startDate} type="text" className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date de début" />
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
                    <input name="end" ref={endDate} type="text" className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date de fin" />
                </div>
            </div>
        </div>
        <br />
        <div className='flex'>
            <div className='flex'>
                <span className="font-ChunkFive text-3xl mr-6">aux environs de :</span>
                <CitiesInput onCitySelect={setCity} marginTop={0} />
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
        {id ? (
            <div className='flex items-center'>
                <span className="font-ChunkFive text-3xl pr-4">pour garder :</span>
                <Select value={selectedAnimals} onChange={setSelectedAnimals} isMulti options={options} className='basic-multi-select w-1/2' classNamePrefix="select" id="select-animals" name="select-animals" />
            </div>
        ) : null}
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
