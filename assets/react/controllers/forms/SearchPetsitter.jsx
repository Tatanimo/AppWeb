import React, { useEffect } from 'react'
import CitiesInput from './CitiesInput'
import ButtonSubmit from '../button/ButtonSubmit'
import { DateRangePicker, Datepicker } from 'flowbite-datepicker';
import fr from 'flowbite-datepicker/locales/fr';


export default function SearchPetsitter() {
    useEffect(() => {
        const dateRangePickerEl = document.getElementById('dateRangePickerId');
        Object.assign(Datepicker.locales, fr);
        new DateRangePicker(dateRangePickerEl, {
            format: 'dd/mm/yyyy',
            language: 'fr',
            minDate : new Date(Date.now() + 86400000),
        }); 
    }, [])
  return (
    <form className="">
        <span className="font-ChunkFive text-4xl">Je recherche quelqu'un du :</span>
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
                <span className="mx-4 text-black font-ChunkFive text-4xl">au</span>
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
                <span className="font-ChunkFive text-4xl mr-6">aux environs de :</span>
                <CitiesInput />
            </div>
            <div className='flex'>
                <span className="font-ChunkFive text-4xl mx-6">dans un rayon de :</span>
                <div className='flex bg-[#EEF0F4] items-center pl-4 rounded-2xl overflow-hidden'>
                    <input type='number' name="radius-of" className='bg-inherit text-xl w-16 border-none' id="radius-of" />
                    <span className='pr-4 text-xl'>km</span>
                </div>
            </div>
        </div>
        <br />
        <div>
            <span className="font-ChunkFive text-4xl pr-4">pour garder :</span>
            <select id="select-animals" name="select-animals">
                <option>Animal 1</option>
                <option>Animal 2</option>
                <option>Animal 3</option>
            </select>
        </div>
        <ButtonSubmit className={"float-right"} content={"Rechercher"} />
    </form>
  )
}
