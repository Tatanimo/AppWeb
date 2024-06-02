import { Modal } from 'flowbite-react'
import React from 'react'

export default function ImageModal({openModal, setOpenModal, image}) {

  return (
    <>
        <Modal dismissible className='[&>div>div]:max-h-dvh [&>div>div]:w-fit [&>div]:flex [&>div]:justify-center' show={openModal} popup onClose={() => setOpenModal(false)}>
            <Modal.Header />
            <Modal.Body className='overflow-hidden'>
                <img src={image} alt="image" className="w-fit object-cover min-w-20" />
            </Modal.Body>
        </Modal>
    </>
  )
}
