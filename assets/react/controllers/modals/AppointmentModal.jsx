import { Modal } from 'flowbite-react'
import React from 'react'
import Appointment from '../forms/Appointment'

export default function AppointmentModal({openModal, setOpenModal, id, professional}) {
  return (
    <Modal className="" dismissible show={openModal} size="xl" popup onClose={setOpenModal}>
        <Modal.Header className='[&>*]:text-4xl [&>*]:font-medium [&>*]:text-gray-900 [&>*]:dark:text-white [&>*]:text-center [&>*]:font-ChunkFive [&>*]:my-4 ml-4'>
            Prendre rendez-vous
        </Modal.Header>
        <Modal.Body>
            <Appointment id={id} professional={professional}/>
        </Modal.Body>
    </Modal>
  )
}
