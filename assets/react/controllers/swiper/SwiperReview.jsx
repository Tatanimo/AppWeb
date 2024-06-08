import React, { useEffect, useState } from "react";
import ReviewCard from "../review/ReviewCard";
// Import Swiper React components
import {Swiper, SwiperSlide} from "swiper/react";
import "swiper/css";
import "swiper/css/navigation";
// import required modules
import {Navigation} from "swiper/modules";

export default () => {

    const [width, setWidth] = useState(window.innerWidth);

    useEffect(() => {
        const handleResize = () => {
        setWidth(window.innerWidth);
        };

        // Ajouter un event listener pour la mise à jour de la taille de la fenêtre
        window.addEventListener('resize', handleResize);

        // Nettoyage du event listener lors du démontage du composant
        return () => {
        window.removeEventListener('resize', handleResize);
        };
    }, []);

    const getSlidesPerView = () => {
        return width > 1440 ? 4.25 : width > 1024 ? 3.25 : width > 640 ? 2.25 : 1.25;
    }

    return (
        <Swiper
            slidesPerView={getSlidesPerView()}
            spaceBetween={32}
            loop={true}
            className="mySwiper flex gap-1 overflow-hidden"
        >
            <SwiperSlide className="[&>div]:!flex-col">
                <ReviewCard img="img/background/dog-with-toy.png"
                            intStar={1}
                            name="Garde de Rockett"/>
            </SwiperSlide>
            <SwiperSlide className="[&>div]:!flex-col">
                <ReviewCard img="img/background/dog-with-toy.png"
                            intStar={3}
                            name="Garde de Rockett"/>
            </SwiperSlide>
            <SwiperSlide className="[&>div]:!flex-col">
                <ReviewCard img="img/background/dog-with-toy.png"
                            intStar={4}
                            name="Garde de Rockett"/>
            </SwiperSlide>
            <SwiperSlide className="[&>div]:!flex-col">
                <ReviewCard img="img/background/dog-with-toy.png"
                            intStar={5}
                            name="Garde de Rockett"/>
            </SwiperSlide>
            <SwiperSlide className="[&>div]:!flex-col">
                <ReviewCard img="img/background/dog-with-toy.png"
                            intStar={5}
                            name="Garde de Rockett"/>
            </SwiperSlide>
            <SwiperSlide className="[&>div]:!flex-col">
                <ReviewCard img="img/background/dog-with-toy.png"
                            intStar={5}
                            name="Garde de Rockett"/>
            </SwiperSlide>
            <SwiperSlide className="[&>div]:!flex-col">
                <ReviewCard img="img/background/dog-with-toy.png"
                            intStar={5}
                            name="Garde de Rockett"/>
            </SwiperSlide>
            <SwiperSlide className="[&>div]:!flex-col">
                <ReviewCard img="img/background/dog-with-toy.png"
                            intStar={5}
                            name="Garde de Rockett"/>
            </SwiperSlide>
        </Swiper>
    );
};