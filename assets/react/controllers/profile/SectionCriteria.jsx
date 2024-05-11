import React, { useState } from 'react'
import AddCriteria from './AddCriteria'
import { endpoint } from '../../../config';

function SectionCriteria({userId, professional}) {
    const professionalObject = JSON.parse(professional);
    const housing = professionalObject.LiveIn == "appartment" ? "un appartement" : "une maison";
    const [criterias, setCriterias] = useState(professionalObject.criteria);

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
                {criterias.map((e, i) => {
                    return(
                        <div key={i} className="flex flex-row items-center">
                            <img className="w-6 mr-4" src={`${endpoint.img}/emojis/${e.emoji}.svg`} alt="icon" />
                            <p className="text-sm">{e.content}</p>
                        </div>
                    )
                })}
        </div>
    </>
  )
}

export default SectionCriteria;