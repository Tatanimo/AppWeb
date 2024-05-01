import React, {useState} from 'react'
import { endpoint } from '../../../config'
import AddUpdateAnimalModal from '../modals/AddUpdateAnimalModal';

function UpdateAnimal({animalId}) {
    const [openModal, setOpenModal] = useState(false);

  return (
    <>
        <button type="button" className='border-solid border-black border-x border-y rounded-full p-4 transition-all hover:opacity-70 active:scale-75' onClick={setOpenModal}>
            <img src={`${endpoint.img}/icons/paint-brush.svg`} alt="paint-brush"/>
        </button>

        {openModal ? (
            <AddUpdateAnimalModal openModal={openModal} setOpenModal={setOpenModal} animalId={animalId}/>
        ) : null}
    </>
  )
}

export default UpdateAnimal