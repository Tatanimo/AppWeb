import React, { useEffect, useRef, useState } from 'react'
import { endpoint } from '../../../config';
import Cropper, { ReactCropperElement } from "react-cropper";
import "cropperjs/dist/cropper.css";
import axios from 'axios';
import { Spinner } from 'flowbite-react';

function convertFraction(string) {
    const parts = string.split('/');
    const numerator = parseInt(parts[0]);
    const denominator = parseInt(parts[1]);

    if (!isNaN(numerator) && !isNaN(denominator) && denominator !== 0) {
        return numerator / denominator;
    } else {
        return null;
    }
}

export default function AdminImage({id, className, alt, userSerialize, classDiv, src, aspect}) {
    const [image, setImage] = useState(true);
    const [file, setFile] = useState();
    const [beforeCropImage, setBeforeCropImage] = useState();
    const [previewVideo, setPreviewVideo] = useState();
    const [loading, setLoading] = useState(false);

    const user = userSerialize ? JSON.parse(userSerialize) : null;
    
    const fileInput = useRef(null);
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
        if (file) {
            file.type.includes("image") ? setBeforeCropImage(URL.createObjectURL(file)) : setBeforeCropImage(null);
            file.type.includes("video") ? setPreviewVideo(URL.createObjectURL(file)) : null;
          }
    }, [file]);

    const saveImage = async () => {
        if (typeof cropperImage.current == "object" && cropperImage.current) {
            cropperImage.current.toBlob(async (blob) => {
                const formData = new FormData();
                formData.append("file", blob);
                
            setLoading(true);
              await axios.post(`/ajax/admin/image/${id}`, formData, {
                headers: {
                  'Content-Type': 'multipart/form-data',
                  'X-Requested-With': 'XMLHttpRequest',
                }
              })
              .then(response => {
                window.location.reload();
              })
              .catch(error => console.error(error))
              .finally(() => setLoading(false));  
            });
        } else {
            if (previewVideo) {
                const formData = new FormData();
                formData.append("file", file);

                setLoading(true);
                await axios.post(`/ajax/admin/image/${id}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => {
                    window.location.reload();
                })
                .catch(error => console.error(error))
                .finally(() => setLoading(false)); 
            }
        }
    }

    const guessExtension = () => {
        if (src[0]) {
            return src[0].split('.').pop();
        }
    }

  return (
    <>
        <div onClick={() => !beforeCropImage && user ? (user.roles.includes("ROLE_ADMIN") ? fileInput.current.click() : null) : null} className={`group relative ${classDiv} ${user && !beforeCropImage ? (user.roles.includes("ROLE_ADMIN") ? "transition-all cursor-pointer" : null) : null}`}>
            {beforeCropImage ? (
                <Cropper
                    aspectRatio={convertFraction(aspect)}
                    src={beforeCropImage}
                    style={{height: "100%", width: "100%"}}
                    minCropBoxWidth={100} minCropBoxHeight={100}
                    guides={false}
                    crop={onCrop}
                    zoomable={false}
                    ref={cropperRef}
                />
            ) : 
            previewVideo ? (
                <video src={previewVideo} className={`${className} ${user && !beforeCropImage ? (user.roles.includes("ROLE_ADMIN") ? "group-hover:opacity-70" : null) : null}`} alt={alt} id={id} controls/> 
            ) :
            image ? (
                guessExtension() == "mp4" ? (
                    <video src={`${endpoint.img}/editable/${src[0].split('/').pop()}?${performance.now()}`} 
                            alt={alt}
                            className={`${className} ${user && !beforeCropImage ? (user.roles.includes("ROLE_ADMIN") ? "group-hover:opacity-70" : null) : null}`} 
                            id={id}
                            controls
                            onError={() => setImage(false)}/>
                ) : (
                    <img src={`${endpoint.img}/editable/${src[0] ? src[0].split('/').pop() : ""}?${performance.now()}`}
                            alt={alt}
                            className={`${className} ${user && !beforeCropImage ? (user.roles.includes("ROLE_ADMIN") ? "group-hover:opacity-70" : null) : null}`} 
                            id={id}
                            onError={() => setImage(false)}/>
                )
            ) : null}
            {(user && !beforeCropImage ? (user.roles.includes("ROLE_ADMIN") ? (
                <span className="transition-opacity duration-300 absolute left-1/2 top-1/2 font-ChunkFive font-bolder text-5xl -translate-x-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100">+</span>
            ) : null) : null)}
            {beforeCropImage ? null : (
                <input type="file" ref={fileInput} onChange={(e) => setFile(e.target.files[0])} name="" accept='image/*, video/*' className='hidden' id="" />
            )}
        </div>
        {beforeCropImage || previewVideo ? (
            loading ? (
                <Spinner className="mt-4 inline-block justify-center float-right h-10 w-10 text-blue-purple"/>
            ) : (
                <button className='z-10 mt-4 inline-block justify-center active:scale-95 hover:bg-blue-purple-hover transition font-ChunkFive text-white text-xl bg-blue-purple px-7 py-5 rounded-xl uppercase' onClick={() => saveImage()}>Sauvegarder</button>
            )
        ) : null}
    </>
  )
}
