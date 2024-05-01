import axios from "axios";
import { Modal } from "flowbite-react";
import React, {useEffect, useState} from 'react'
import ReactCrop from 'react-image-crop'
import 'react-image-crop/dist/ReactCrop.css'

export default function SquareImage({srcPath, main, number, userId, animalId}) {
  const [crop, setCrop] = useState();
  const [openModal, setOpenModal] = useState(false);
  const [file, setFile] = useState();
  const [newImage, setNewImage] = useState('');
  const [beforeCropImage, setBeforeCropImage] = useState();
  const [cropImage, setCropImage] = useState();

  useEffect(() => {
    if (!openModal) {
      setFile();
    }
  }, [openModal])

  useEffect(() => {
    if (file) {
      setBeforeCropImage(URL.createObjectURL(file));
    }
  }, [file])

  // const handleCrop = async () => {
  //   const response = await fetch(beforeCropImage);
  //   const imageBitmap = await createImageBitmap(await response.blob());
  //   console.log(crop);
  //   const image = createImageBitmap(imageBitmap, crop.x, crop.y, crop.width, crop.height)


  //   setNewImage(image); 
  // }

  const saveImage = async () => {
    if (typeof file == "object") {

      if (number && userId || number && animalId) {
        const formData = new FormData();
        formData.append("file", file);
        formData.append("to", userId ? "users" : "animals")
        
        await axios.post(`/ajax/profile/${userId ?? animalId}/${number}`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
            'X-Requested-With': 'XMLHttpRequest',
          }
        })
        .then(response => {
          const randomParam = Math.random();
          if (userId) {
            setNewImage(`/img/users/user-${userId}-${number}.${response.data}?${randomParam}`);
          }
          if (animalId) {
            setNewImage(`/img/animals/animal-${animalId}-${number}.${response.data}?${randomParam}`);
          }
        })
        .catch(error => console.error(error));
      }
    }
  }

    return (
      <>
        <div onClick={() => setOpenModal(true)} className={`transition-opacity bg-light-gray cursor-pointer relative group hover:opacity-85 aspect-square ${main ? 'w-full' : 'w-1/3' }`}>  
          {newImage ? <img src={newImage} className="w-full h-full object-cover" alt="user image" /> : srcPath ? <img src={srcPath} className="w-full h-full object-cover" alt="user image" /> : null}
          <span className="transition-opacity duration-300 absolute left-1/2 top-1/2 font-ChunkFive font-bolder text-5xl -translate-x-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100">+</span>
        </div>

        <Modal className="" dismissible show={openModal} size="md" popup onClose={() => setOpenModal(false)}>
          <Modal.Header />
            <Modal.Body>
              <input type="file" accept="image/png, image/jpeg, image/jpg" name="" id="" onChange={(e) => setFile(e.target.files[0])} />
              {typeof file == "object" ? (
                <>
                  <ReactCrop minHeight={100} minWidth={100} keepSelection={true} aspect={1} crop={crop} onChange={c => setCrop(c)} onComplete={handleCrop}>
                    {beforeCropImage ? (<img src={beforeCropImage} />) : null}
                  </ReactCrop>
                  {crop ? (
                    <button type="button" className="mt-4 inline-block justify-center active:scale-95 hover:bg-blue-purple-hover transition font-ChunkFive text-white text-base bg-blue-purple px-3 py-2 rounded-xl uppercase float-right" onClick={saveImage}>Envoyer</button>
                  ) : null}
                </>
              ) : null}
          </Modal.Body>
        </Modal>
      </>
    )
}
