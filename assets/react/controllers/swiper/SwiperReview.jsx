import React from "react";
import ReviewCard from "../review/ReviewCard";
// Import Swiper React components
import {Swiper, SwiperSlide} from "swiper/react";
import "swiper/css";
import "swiper/css/navigation";
// import required modules
import {Navigation} from "swiper/modules";

export default () => {
    return (
        <Swiper
            slidesPerView={1}
            spaceBetween={16}
            navigation={true}
            loop={true}
            modules={[Navigation]}
            className="mySwiper flex gap-1 overflow-hidden [&_.swiper-slide]:!w-full xl:w-[1150px] lg:w-[700px] w-[300px]"
        >
            <SwiperSlide>
                <ReviewCard img="img/background/dog-with-toy.png"
                            intStar={1}
                            name="Garde de Rockett"/>
            </SwiperSlide>
            <SwiperSlide>
                <ReviewCard img="img/background/dog-with-toy.png"
                            intStar={3}
                            name="Garde de Rockett"/>
            </SwiperSlide>
            <SwiperSlide>
                <ReviewCard img="img/background/dog-with-toy.png"
                            intStar={4}
                            name="Garde de Rockett"/>
            </SwiperSlide>
            <SwiperSlide>
                <ReviewCard img="img/background/dog-with-toy.png"
                            intStar={5}
                            name="Garde de Rockett"/>
            </SwiperSlide>
            <SwiperSlide>
                <ReviewCard img="img/background/dog-with-toy.png"
                            intStar={5}
                            name="Garde de Rockett"/>
            </SwiperSlide>
            <SwiperSlide>
                <ReviewCard img="img/background/dog-with-toy.png"
                            intStar={5}
                            name="Garde de Rockett"/>
            </SwiperSlide>
            <SwiperSlide>
                <ReviewCard img="img/background/dog-with-toy.png"
                            intStar={5}
                            name="Garde de Rockett"/>
            </SwiperSlide>
            <SwiperSlide>
                <ReviewCard img="img/background/dog-with-toy.png"
                            intStar={5}
                            name="Garde de Rockett"/>
            </SwiperSlide>
        </Swiper>
    );
};