import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faStar as faStarRegular } from '@fortawesome/free-regular-svg-icons';
import { faStar as faStarSolid } from '@fortawesome/free-solid-svg-icons';
import React, { useEffect, useState } from 'react'
import MainImage from '../images/MainImage';

function ReviewCard({review}) {
    const [stars, setStars] = useState([]);

    useEffect(() => {
        const regular = 5 - review.rating;
        const arr = [];
        for (let index = 0; index < review.rating; index++) {
            arr.push(faStarSolid);
        }

        for (let index = 0; index < regular; index++) {
            arr.push(faStarRegular);
        }
        
        setStars(arr);
    }, []);

    console.log(review)
  return (
    <div className='flex flex-row border border-black rounded-2xl py-8 px-4 my-8'>
        <div className='w-1/3 overflow-hidden mr-8'>
            <MainImage id={review.user.id}/>
        </div>
        <div>
            <div id='rating' className='flex mb-2 gap-1'>
                {stars.map((e, i) => {
                    return(
                        <FontAwesomeIcon className='text-[#31A39D]' key={i} icon={e} />
                    )
                })}
            </div>
            <h1 className='font-ChunkFive text-xl'>
                <span className='capitalize'>{review.user.first_name} </span>
                <span className='uppercase'>{review.user.last_name}</span>
            </h1>
            <p>{review.comment}</p>
        </div>
    </div>
  )
}

export default ReviewCard