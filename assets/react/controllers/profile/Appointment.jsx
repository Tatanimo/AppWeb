import React, { useState } from 'react'
import AppointmentModal from '../modals/AppointmentModal';

export default function Appointment({id, professional}) {
    const [openModal, setOpenModal] = useState(false);
    const professionalJSON = JSON.parse(professional);

  return (
    <>
        <button onClick={setOpenModal} className="inline-block justify-center active:scale-95 hover:bg-blue-purple-hover transition font-ChunkFive text-white text-xl bg-blue-purple px-7 py-5 rounded-xl uppercase">Prendre rendez-vous</button>
        <AppointmentModal setOpenModal={setOpenModal} openModal={openModal} id={id} professional={professionalJSON}/>
    </>
  )
}
