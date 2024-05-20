import React from "react";
import {endpoint} from "../../../config";

export default function ChatTopBar(author, lastName, firstName, cityName) {
    console.log(author.author);
    return (
        <div className="flex items-center justify-between gap-4">
            <a href={`${endpoint.base}/messages`}
               className="flex items-center justify-center gap-2 rounded-full hover:bg-blue-purple-dark-hover transition">
                <img src={`${endpoint.img}/icons/arrow-left.svg`}
                     alt="Retour"
                     className="h-[48px] w-[48px]"/>
            </a>
            <div className="flex items-center justify-between gap-4">
                <div className="flex flex-col">
                    <h1 className="font-ChunkFive text-dark-blue text-xl mb-0 min-w-fit hover:underline">
                        <a href={`${endpoint.base}/profil/${author.author}`}>
                            {author.lastName} {author.firstName}
                        </a>
                    </h1>
                    <span>{author.cityName}</span>
                </div>
                <a href={`${endpoint.base}/profil/${author.author}`}
                   className="overflow-hidden rounded-full">
                    <img src={`${endpoint.img}/users/user-${author.author}-1.jpg`}
                         className="w-[80px] h-[80px] object-cover rounded-full hover:scale-110 transition"
                         alt="Logo utilisateur"/>
                </a>
            </div>
        </div>
    );
}