import React, {useState} from 'react'
import { endpoint } from '../../../config';
import AddCriteriaModal from '../modals/AddCriteriaModal';

function AddCriteria({professionalId, setCriterias}) {
    const [openModal, setOpenModal] = useState(false);

  return (
    <>
        <div id="add-criteria" onClick={setOpenModal} className="transition-all text-white font-ChunkFive text-4xl w-fit bg-black rounded-full py-1 px-2 cursor-pointer hover:opacity-80 active:scale-75 aspect-square content-center">
            <img src={`${endpoint.img}/icons/plus.svg`} alt="icône plus" className='w-4' />
        </div>

        {openModal ? (
            <AddCriteriaModal openModal={openModal} setOpenModal={setOpenModal} professionalId={professionalId} setCriterias={setCriterias}/>
        ) : null}
    </>
  )
}

export default AddCriteria