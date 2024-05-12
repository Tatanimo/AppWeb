import React, { useState } from 'react'
import { endpoint } from '../../../config';
import SquareImage from './SquareImage';

function MainImage({professional, userId}) {
    const professionalObject = JSON.parse(professional);
    const [imgAvailable, setImgAvailable] = useState(true);
  return (
    <>
        {imgAvailable ? (
            <img className='aspect-square object-cover' src={`${endpoint.img}/professionals/professional-${professionalObject.id}-1.jpg`} onError={() => setImgAvailable(false)} alt="photo de profil" />
        ) : professionalObject.user.id == userId ? (
            <SquareImage srcPath={null} main={true} number={1} userId={userId}/>
        ) : (
            <div className='aspect-square bg-gray-200'></div>
        )}
    </>
  )
}

export default MainImage