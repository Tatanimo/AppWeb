import React, { useState } from 'react'
import AddCriteria from './AddCriteria'
import { endpoint } from '../../../config';
import { ReactSVG } from 'react-svg';
import axios from 'axios';

function SectionCriteria({userId, professional}) {
    const professionalObject = JSON.parse(professional);
    const housing = professionalObject.LiveIn == "appartment" ? "un appartement" : "une maison";
    const [criterias, setCriterias] = useState(professionalObject.criteria);

    const handleDelete = async (e) => {
        axios.post(`/ajax/professional/criteria/delete/${professionalObject.id}`, {
            criteria: e
        }, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => setCriterias(res.data))
        .catch(err => console.error(err));
    }

  return (
    <>
        <div className="flex flex-row items-center justify-between">
            <h5 className="font-semibold">Accueil</h5>
            {professionalObject.user.id == userId ? (
                <AddCriteria professionalId={professionalObject.id} setCriterias={setCriterias}/>
            ) : null}
        </div>
        <br/>
        <div className="grid grid-cols-2 grid-rows-1 gap-6">
                <div className="flex flex-row items-center">
                    <img className="w-6 mr-4" alt="icon" src={`${endpoint.img}/emojis/${professionalObject.LiveIn}.svg`} />
                    <p className="text-sm">Habite dans {housing}</p>
                </div>
                {criterias != null && criterias.length > 0 ? criterias.map((e, i) => {
                    return(
                        <div key={i} className="flex flex-row items-center group">
                            <img className="w-6 mr-4" src={`${endpoint.img}/emojis/${e.emoji}.svg`} alt="icon" />
                            <p className="text-sm cursor-default">{e.content}</p>
                            {professionalObject.user.id == userId ? (
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

export default SectionCriteria;