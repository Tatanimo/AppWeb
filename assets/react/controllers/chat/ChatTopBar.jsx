import React, {useState} from "react";
import {endpoint} from "../../../config";

export default function ChatTopBar({contactSerialize, roomsPro, professionalSerialize}) {
    const [imgNotFound, setImgNotFound] = useState(false);
    const contact = JSON.parse(contactSerialize);
    const professional = JSON.parse(professionalSerialize);
    console.log(roomsPro);
    console.log(professional);

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
                        <a href={`${endpoint.base}/profil/${contact.id}`}>
                            {contact.last_name} {contact.first_name}
                        </a>
                    </h1>
                    <span>{contact.cities.name}</span>
                </div>
                <a href={`${endpoint.base}/profil/${contact.id}`}
                   className="overflow-hidden rounded-full bg-gray-200 w-[80px] h-[80px]">

                    <img src={`${endpoint.img}/${roomsPro == professional.id ? `professionals/professional-${professional.id}` : `users/user-${professional.user.id}`}-1.jpg`}
                         className="w-[80px] h-[80px] object-cover rounded-full hover:scale-110 transition"
                         alt="Logo utilisateur"
                         onError={() => setImgNotFound(true)}/>

                </a>
            </div>
        </div>
    );
}