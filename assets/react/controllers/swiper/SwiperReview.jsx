import React from "react";
import ReviewCard from "../review/ReviewCard";
// Import Swiper React components
import {Swiper, SwiperSlide} from "swiper/react";
import "swiper/css";
import "swiper/css/free-mode";
// import required modules
import {FreeMode} from "swiper/modules";

export default () => {
    return (
        <Swiper
            slidesPerView={"auto"}
            spaceBetween={30}
            freeMode={true}
            modules={[FreeMode]}
            className="mySwiper flex gap-2 overflow-hidden [&_.swiper-slide]:!w-[350px] w-[1000px]"
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