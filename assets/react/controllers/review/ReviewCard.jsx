import React from "react";

export default function ReviewCard({img, intStar, name}) {
    const arrReview = new Array(intStar);

    for (let i = 0; i < arrReview.length; i++) {
        arrReview[i] = "img/icons/star.svg";
    }

    return (
        <div className="border border-black p-12 rounded-3xl w-[325px]">
            <div>
                <img src={img}
                     alt="Image de profil utilisateur"
                     className="rounded-xl mb-6"/>
            </div>
            <div>
                <div className="flex pb-2">
                    {arrReview.map((item, i) => <img key={i}
                                                     src={arrReview[i]}
                                                     alt="Etoile d'avis"/>)}
                </div>
                <span className="font-ChunkFive text-2xl">{name}</span>
                <p>La garde de Rockett s’est très bien passée...</p>
            </div>
        </div>
    );
}