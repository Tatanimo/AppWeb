import React, { useState } from "react";

export default function ReviewCard({img, intStar, firstname, lastname, comment}) {
    const arrReview = new Array(5);
    const [image, setImage] = useState(true);

    for (let i = 0; i < 5; i++) {
        if (i <= intStar - 1) {
            arrReview[i] = "img/icons/star-fill.svg";
        } else {
            arrReview[i] = "img/icons/star-outline.svg";
        }
    }

    return (
        <div className="border border-black lg:p-12 p-6 rounded-3xl w-full flex lg:flex-row flex-col gap-4">
            <div>
                {image === true ? (
                    <img src={img}
                         alt="Image de profil utilisateur"
                         className="rounded-xl h-full w-full object-cover"
                         onError={() => setImage(false)}/>
                ) : null}
            </div>
            <div className="w-full">
                <div className="flex pb-2">
                    {arrReview.map((item, i) => <img key={i}
                                                     src={arrReview[i]}
                                                     alt="Etoile d'avis"/>)}
                </div>
                <p className="font-ChunkFive text-2xl">
                    <span className="capitalize">{firstname} </span>
                    <span className="uppercase">{lastname}</span>
                </p>
                <p className="break-words">{comment}</p>
            </div>
        </div>
    );
}