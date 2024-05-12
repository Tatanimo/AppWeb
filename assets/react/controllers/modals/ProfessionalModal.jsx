import React from 'react'
import { Modal } from 'flowbite-react';
import Professional from '../forms/Professional';

function ProfessionalModal({openModal, setOpenModal}) {
  return (
    <Modal className="" dismissible show={openModal} size="md" popup onClose={setOpenModal}>
        <Modal.Header className='[&>*]:text-4xl [&>*]:font-medium [&>*]:text-gray-900 [&>*]:dark:text-white [&>*]:text-center [&>*]:font-ChunkFive [&>*]:my-4'>
            Devenir professionnel
        </Modal.Header>
        <Modal.Body>
            <Professional setOpenModal={setOpenModal} />
        </Modal.Body>
    </Modal>
  )
}

export default ProfessionalModal