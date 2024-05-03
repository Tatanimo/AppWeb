import React, { useState } from 'react'
import { endpoint } from '../../../config';
import { faStar as faStarRegular } from '@fortawesome/free-regular-svg-icons';
import { faStar as faStarSolid } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

function PetsitterCard({user, dist}) {
    const [imgValid, setImgValid] = useState(true);
  return (
    <div id="card-petsitter" className='mx-4 my-2 p-4 rounded-2xl border-8 border-[#F59C23] max-w-[416px] w-full'>
        <div id="card-petsitter-header" className='flex mb-2'>
            <div id="photo-profile" className='overflow-hidden rounded-full aspect-square bg-gray-200 min-w-32 max-w-32 mr-4'>
                {imgValid ? (
                    <img src={`${endpoint.img}/users/user-${user.id}-1.jpg`} onError={setImgValid(false)} alt="utilisateur" />
                ) : null}
            </div>
            <div className='flex flex-col place-content-between'>
                <div>
                    <h1 className='font-ChunkFive text-3xl uppercase'>{user.last_name}</h1>
                    <h1 className='font-ChunkFive text-3xl capitalize'>{user.first_name}</h1>
                </div>
                <div className='flex'>
                    <img src={`${endpoint.img}/icons/paw.svg`} alt="logo d'une patte" />
                    <p className='mr-2'>2 animaux</p>
                    <img src={`${endpoint.img}/icons/house.svg`} alt="logo d'une maison" />
                    <p>maison</p>
                </div>
            </div>
        </div>
        <div id="card-petsitter-body" className='ml-2 mt-2'>
            <h4 className='text-xl'>{user.cities.name}</h4>
            <div id='rating' className='flex mb-2 gap-1'>
                <FontAwesomeIcon  icon={faStarRegular} />
                <FontAwesomeIcon  icon={faStarRegular} />
                <FontAwesomeIcon  icon={faStarRegular} />
                <FontAwesomeIcon  icon={faStarRegular} />
                <FontAwesomeIcon icon={faStarRegular} />
            </div>
            <p className='line-clamp-3 text-lg'>{user.description}</p>
        </div>
        <div id="card-petsitter-footer" className='flex justify-end my-2'>
            <h1 className='font-ChunkFive text-3xl'>Prix / Nuit</h1>
        </div>
    </div>
  )
}

export default PetsitterCard