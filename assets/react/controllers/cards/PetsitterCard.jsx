import React, { useState } from 'react'
import { endpoint } from '../../../config';
import { faStar as faStarRegular } from '@fortawesome/free-regular-svg-icons';
import { faStar as faStarSolid } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

function PetsitterCard({professional, dist}) {
    const [imgValid, setImgValid] = useState(true);
    const animals = professional.user.animals.length > 1 ? `${professional.user.animals.length} animaux` : professional.user.animals.length == 1 ? `${professional.user.animals.length} animal` : null;

  return (
    <a id="card-petsitter" className='flex flex-col mx-4 my-2 p-4 rounded-2xl border-8 border-[#F59C23] max-w-[416px] w-full cursor-pointer transition-all active:scale-90 hover:opacity-70' href={`/profil/professionnel/${professional.id}`}>
        <div id="card-petsitter-header" className='flex mb-2'>
            <div id="photo-profile" className='overflow-hidden rounded-full aspect-square bg-gray-200 min-w-32 max-w-32 mr-4'>
                {imgValid ? (
                    <img src={`${endpoint.img}/users/user-${professional.user.id}-1.jpg`} onError={() => setImgValid(false)} alt="utilisateur" />
                ) : null}
            </div>
            <div className='flex flex-col place-content-between'>
                <div>
                    <h1 className='font-ChunkFive text-3xl uppercase'>{professional.user.last_name}</h1>
                    <h1 className='font-ChunkFive text-3xl capitalize'>{professional.user.first_name}</h1>
                </div>
                {animals ? (
                    <div className='flex'>
                        <img src={`${endpoint.img}/icons/paw.svg`} alt="logo d'une patte" />
                        <p className='mr-2'>{animals}</p>
                        <img src={`${endpoint.img}/icons/house.svg`} alt="logo d'une maison" />
                        <p>{professional.LiveIn == "appartment" ? "appartement" : "maison"}</p>
                    </div>
                ) : null}
            </div>
        </div>
        <div id="card-petsitter-body" className='ml-2 mt-2 flex-1'>
            <h4 className='text-xl'>{professional.city.name}</h4>
            <div id='rating' className='flex mb-2 gap-1'>
                <FontAwesomeIcon  icon={faStarRegular} />
                <FontAwesomeIcon  icon={faStarRegular} />
                <FontAwesomeIcon  icon={faStarRegular} />
                <FontAwesomeIcon  icon={faStarRegular} />
                <FontAwesomeIcon icon={faStarRegular} />
            </div>
            <p className='line-clamp-3 text-lg'>{professional.description}</p>
        </div>
        <div id="card-petsitter-footer" className='flex justify-end my-2'>
            <h1 className='font-ChunkFive text-3xl'>{professional.price}€ / Jour</h1>
        </div>
    </a>
  )
}

export default PetsitterCard