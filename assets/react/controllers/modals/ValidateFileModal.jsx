import axios from 'axios'
import { Modal } from 'flowbite-react'
import React from 'react'

export default function ValidateFileModal({openModal, setOpenModal, file, room}) {
  const sendFile = async () => {
    if (file) {
      const ext = file.name.split('.').pop();
      const formData = new FormData();
      formData.append('file', file);
      formData.append('ext', ext);
      
      await axios.post(`/ajax/messages/file/${room}`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
          "X-Requested-With": "XMLHttpRequest",
        }
      })
      .then(res => setOpenModal(false))
      .catch(err => console.error(err));
    }
  }

  return (
    <>
        <Modal dismissible show={openModal} size="md" popup onClose={() => setOpenModal(false)}>
            <Modal.Header className='absolute right-0'></Modal.Header>
            <Modal.Body>
                <article className='flex flex-col justify-center m-4'>
                  <h2 className='text-xl self-center'>Confirmez-vous l'ajout du fichier ?</h2>
                  <br />
                  <div className='flex gap-4 justify-center'>
                      <button onClick={() => sendFile()} type="button" className='transition-all hover:opacity-85 active:scale-75 w-1/2 rounded-xl px-8 py-4 text-black bg-gray-300'>Je confirme</button>
                      <button onClick={() => setOpenModal(false)} type="button" className='transition-all hover:opacity-85 active:scale-75 w-1/2 rounded-xl px-8 py-4 bg-red-500 text-white'>Annuler</button>
                  </div>
                </article>
            </Modal.Body>
        </Modal>
    </>
  )
}
