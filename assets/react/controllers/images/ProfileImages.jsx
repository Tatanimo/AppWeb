import React from 'react'
import SquareImage from './SquareImage'

export default function ProfileImages({userId, images, animalId, profilUser}) {

    function findImage(number){
        const img = images.find((img) => img.split('-').pop().split('.').shift() == number);
        return img ? img.split('/public/').pop() : null;
    }

  return (
    <>
        <SquareImage srcPath={findImage(1)} main={true} number={1} userId={userId} animalId={animalId} profilUser={profilUser} />
        <div className="flex justify-between mt-3 gap-3 w-full">
            {[2,3,4].map((e) => {
                return (
                    <SquareImage key={e} srcPath={findImage(e)} number={e} userId={userId} animalId={animalId} profilUser={profilUser} />
                )
            })}
        </div>
    </>
  )
}
