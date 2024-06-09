import React, { useEffect, useState } from "react";
import ReviewCard from "../review/ReviewCard";
// Import Swiper React components
import {Swiper, SwiperSlide} from "swiper/react";
import "swiper/css";
import "swiper/css/navigation";
// import required modules
import {Navigation} from "swiper/modules";

export default ({ratingsSerialize}) => {
    const [width, setWidth] = useState(window.innerWidth);
    const [ratings, setRatings] = useState(JSON.parse(ratingsSerialize));

    useEffect(() => {
        const handleResize = () => {
            setWidth(window.innerWidth);
        };

        window.addEventListener('resize', handleResize);

        return () => {
        window.removeEventListener('resize', handleResize);
        };
    }, []);

    const getSlidesPerView = () => {
        return width > 1440 ? 4.25 : width > 1024 ? 3.25 : width > 640 ? 2.25 : 1.25;
    }
    
    console.log(ratings[0].user)
    return (
        <Swiper
            slidesPerView={getSlidesPerView()}
            spaceBetween={32}
            loop={true}
            className="mySwiper flex gap-1 overflow-hidden [&>div]:cursor-grab [&>div]:active:cursor-grabbing"
        >   
            {ratings.map((rating, index) => (
                <SwiperSlide key={index} className="[&>div]:!flex-col">
                    <ReviewCard img={`img/users/user-${rating.user.id}-1.jpg`}
                                intStar={rating.rating}
                                firstname={rating.user.first_name}
                                lastname={rating.user.last_name}
                                comment={rating.comment}/>
                </SwiperSlide>
            ))}
        </Swiper>
    );
};