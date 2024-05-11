import axios from 'axios'
import React, { useEffect, useState } from 'react'
import ReviewCard from './ReviewCard';
import ButtonSubmit from '../button/ButtonSubmit';

function Reviews({idProfessional}) {
    const [reviews, setReviews] = useState([]);
    const [reviewsLength, setReviewsLength] = useState(3);

    useEffect(() => {
        axios.get(`/ajax/professional/${idProfessional}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => setReviews(res.data.reviews.filter(e => e.professional_receiver == true)))
        .catch(err => console.error(err));
    }, [])
    console.log(reviews.length)
  return (
    <>
        {reviews.length == 0 ? (
            <h3 className='font-ChunkFive text-2xl self-center mt-4'>Aucune évaluation</h3>
        ) : null}
        {reviews.slice(0, reviewsLength).map((e, i) => {

            return(
                <ReviewCard key={i} review={e}/>
            )
        })}
        {reviewsLength <= reviews.length ? (
            <button type='button' onClick={() => setReviewsLength(reviewsLength + 3)} className='inline-block justify-center active:scale-95 hover:bg-blue-purple-hover transition font-ChunkFive text-white text-xl bg-blue-purple px-7 py-5 rounded-xl uppercase'>Voir plus</button>
        ) : null}
    </>
  )
}

export default Reviews