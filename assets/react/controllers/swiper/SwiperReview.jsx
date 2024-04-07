import React from "react";
// Import Swiper React components
import {Swiper, SwiperSlide} from "swiper/react";

// Import Swiper styles
import "swiper/css";
import "swiper/css/navigation";
import {Navigation} from "swiper/modules";

export default function SwiperReview() {
    return (
        <Swiper modules={[Navigation]}
                className="w-full">
            <SwiperSlide>
                Slide 1
            </SwiperSlide>
        </Swiper>
    );
}

/*                <ReviewCard img="img/background/dog-with-toy.png"
                            intStar={5}
                            name="Garde de Rockett"/>*/