import React from "react";

export default function ReviewCard({img, intStar, name}) {
    const arrReview = new Array(5);

    for (let i = 0; i < 5; i++) {
        if (i <= intStar - 1) {
            arrReview[i] = "img/icons/star-fill.svg";
        } else {
            arrReview[i] = "img/icons/star-outline.svg";
        }
    }

    return (
        <div className="border border-black p-12 rounded-3xl w-full flex lg:flex-row flex-col gap-4">
            <div>
                <img src={img}
                     alt="Image de profil utilisateur"
                     className="rounded-xl h-full w-full object-cover"/>
            </div>
            <div className="w-full">
                <div className="flex pb-2">
                    {arrReview.map((item, i) => <img key={i}
                                                     src={arrReview[i]}
                                                     alt="Etoile d'avis"/>)}
                </div>
                <span className="font-ChunkFive text-2xl">{name}</span>
                <p>La garde de Rockett s’est très bien passée... Lorem ipsum dolor sit amet, consectetur adipisicing
                    elit. Ad, animi cumque dicta distinctio dolores doloribus, earum enim esse hic iste iure maiores
                    maxime nesciunt placeat quae quod veritatis! Blanditiis, enim</p>
            </div>
        </div>
    );
}