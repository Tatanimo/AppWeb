import axios from "axios";
import { Modal, Spinner } from "flowbite-react";
import React, {useEffect, useState, useRef} from 'react'
import Cropper, { ReactCropperElement } from "react-cropper";
import "cropperjs/dist/cropper.css";

export default function SquareImage({srcPath, main, number, userId, animalId}) {
  console.log(srcPath)
  const [openModal, setOpenModal] = useState(false);
  const [file, setFile] = useState();
  const [newImage, setNewImage] = useState('');
  const [beforeCropImage, setBeforeCropImage] = useState();
  const [uploadingImage,  setUploadingImage] = useState(false);
  
  const timerRef = useRef(null);
  const cropperRef = useRef(null);
  const cropperImage = useRef(null);

  const onCrop = () => {
    if (timerRef.current) {
      clearTimeout(timerRef.current);
    }
    
    timerRef.current = setTimeout(() => {
      const cropper = cropperRef.current?.cropper;
      cropperImage.current = cropper.getCroppedCanvas();
    }, 500);
  };

  useEffect(() => {
    if (!openModal) {
      setFile();
      cropperImage.current = null;
    }
  }, [openModal])

  useEffect(() => {
    if (file) {
      setBeforeCropImage(URL.createObjectURL(file));
    }
  }, [file])

  const saveImage = () => {
    if (typeof cropperImage.current == "object") {
      if (number && userId || number && animalId) {
        cropperImage.current.toBlob(async (blob) => {
          const formData = new FormData();
          formData.append("file", blob);
          formData.append("to", userId ? "users" : "animals")
          
          setUploadingImage(true);
          await axios.post(`/ajax/profile/${userId ?? animalId}/${number}`, formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
              'X-Requested-With': 'XMLHttpRequest',
            }
          })
          .then(response => {
            const randomParam = Math.random();
            if (userId) {
              setNewImage(`/img/users/user-${userId}-${number}.jpg?${randomParam}`);
            }
            if (animalId) {
              setNewImage(`/img/animals/animal-${animalId}-${number}.jpg?${randomParam}`);
            }
            setUploadingImage(false);
          })
          .catch(error => setUploadingImage(false));
        });
      }
    }
  }

    return (
      <>
        <div onClick={() => setOpenModal(true)} className={`transition-opacity bg-light-gray cursor-pointer relative group hover:opacity-85 aspect-square ${main ? 'w-full' : 'w-1/3' }`}>  
          {newImage ? <img src={newImage} className="w-full h-full object-cover" alt="user image" /> : srcPath ? <img src={`/${srcPath}`} className="w-full h-full object-cover" alt="user image" /> : null}
          <span className="transition-opacity duration-300 absolute left-1/2 top-1/2 font-ChunkFive font-bolder text-5xl -translate-x-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100">+</span>
        </div>

        <Modal className="" dismissible show={openModal} size="md" popup onClose={() => setOpenModal(false)}>
          <Modal.Header />
            <Modal.Body>
              <input type="file" accept="image/*" name="" id="" onChange={(e) => setFile(e.target.files[0])} />
              {typeof file == "object" ? (
                <>
                  {beforeCropImage ? (
                      <Cropper
                        aspectRatio={1/1}
                        src={beforeCropImage}
                        minCropBoxWidth={100} minCropBoxHeight={100}
                        guides={false}
                        crop={onCrop}
                        ref={cropperRef}
                      />
                  ) : null}

                  {typeof cropperImage.current == "object" && uploadingImage == false ? (
                    <button type="button" className="mt-4 inline-block justify-center active:scale-95 hover:bg-blue-purple-hover transition font-ChunkFive text-white text-base bg-blue-purple px-3 py-2 rounded-xl uppercase float-right" onClick={saveImage}>Envoyer</button>
                  ) : <Spinner className="mt-4 inline-block justify-center float-right h-10 w-10 text-blue-purple"/>}
                </>
              ) : null}
          </Modal.Body>
        </Modal>
      </>
    )
}
