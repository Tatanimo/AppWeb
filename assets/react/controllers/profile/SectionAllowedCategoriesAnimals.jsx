import React, { useState } from 'react'
import { endpoint } from '../../../config';
import { ReactSVG } from 'react-svg';
import axios from 'axios';
import AddCategoryAnimal from './AddCategoryAnimal';

function SectionAllowedCategoriesAnimals({userId, professional}) {
    const professionalObject = JSON.parse(professional);
    const [categoriesAnimals, setCategoriesAnimals] = useState(professionalObject.allowed_categories);

    const handleDelete = async (e) => {
        axios.post(`/ajax/categoriesanimals/delete/${e.id}/${professionalObject.id}`, {}, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => {
            setCategoriesAnimals(Object.values(res.data.allowed_categories))})
        .catch(err => console.error(err));
    }

  return (
    <>
        <div className="flex flex-row items-center justify-between">
            <h5 className="font-semibold">{categoriesAnimals.length > 1 ? "Animaux" : "Animal"} pris en charge</h5>
            {professionalObject.user.id == userId ? (
                <AddCategoryAnimal professionalId={professionalObject.id} setCategoriesAnimals={setCategoriesAnimals}/>
            ) : null}
        </div>
        <br/>
        <div className="grid grid-cols-2 grid-rows-1 gap-6">
                {categoriesAnimals != null && categoriesAnimals.length > 0 ? categoriesAnimals.map((e, i) => {
                    return(
                        <div key={i} className="flex flex-row items-center group">
                            <img className="w-6 mr-4" src={`${endpoint.img}/icons/animals/${e.name.toLowerCase()}.svg`} alt="icon" />
                            <p className="text-sm cursor-default">{e.name}</p>
                            {professionalObject.user.id == userId && categoriesAnimals.length > 1 ? (
                                <button type='button' className='w-6 ml-2 opacity-0 transition-all group-hover:opacity-100 hover:fill-red-600 active:fill-red-500 active:scale-75' onClick={() => handleDelete(e)}>
                                    <ReactSVG src={`${endpoint.img}/icons/delete.svg`} />
                                </button>
                            ) : null }
                        </div>
                    )
                }) : null}
        </div>
    </>
  )
}

export default SectionAllowedCategoriesAnimals;