import React from 'react'
import SquareImage from './SquareImage'

export default function ProfileImages({userId, images}) {

    function findImage(number){
        const img = images.find((img) => img.split('-').pop().split('.').shift() == number);
        return img ? img.split('/public/').pop() : null;
    }

  return (
    <>
        <SquareImage srcPath={findImage(1)} main={true} number={1} userId={userId} />
        <div className="flex justify-between mt-3 gap-3 max-w-96">
            {[2,3,4].map((e) => {
                return (
                    <SquareImage key={e} srcPath={findImage(e)} number={e} userId={userId} />
                )
            })}
        </div>
    </>
  )
}