import React, { useState } from 'react'
import { endpoint } from '../../../config';

function MainImage({id}) {
    const [imgAvailable, setImgAvailable] = useState(true);
  return (
    <>
        {imgAvailable ? (
            <img className='aspect-square object-cover' src={`${endpoint.img}/users/user-${id}-1.jpg`} onError={() => setImgAvailable(false)} alt="photo de profil" />
        ) : (
            <div className='aspect-square bg-gray-200'></div>
        )}
    </>
  )
}

export default MainImage