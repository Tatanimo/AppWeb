import React, { useState } from 'react'
import { endpoint } from '../../../config'
import { Tooltip } from 'react-tooltip'
import AddUpdateAnimalModal from '../modals/AddUpdateAnimalModal';

export default function AddAnimal({setFetchById}) {
    const [openModal, setOpenModal] = useState(false);

  return (
    <>
        <div id="add-animal-btn" onClick={setOpenModal} className="transition-all text-white font-ChunkFive text-4xl w-fit bg-black rounded-full py-2 px-4 cursor-pointer hover:opacity-80 active:scale-75 aspect-square content-center">
            <img src={`${endpoint.img}/icons/plus.svg`} alt="icône plus" className='w-8' />
        </div>

        {openModal ? (
            <AddUpdateAnimalModal openModal={openModal} setOpenModal={setOpenModal} type={"add"} setFetchById={setFetchById}/>
        ) : null}

        <Tooltip anchorSelect="#add-animal-btn" place="top">
          Ajouter un animal
        </Tooltip>
    </>
  )
}
