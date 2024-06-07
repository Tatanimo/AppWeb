import React, {useEffect, useState} from "react";
import {endpoint} from "../../../config";
import datetimeDifference from "datetime-difference";

export default function Message({roomSerialize, contactSerialize, lastMessageSerialize}) {
    const room = JSON.parse(roomSerialize);
    const contact = JSON.parse(contactSerialize);
    const lastMessage = JSON.parse(lastMessageSerialize);

    const [notifsStorage, setNotifsStorage] = useState(localStorage.getItem("notifications"));
    const [imgAvailable, setImgAvailable] = useState(true);

    const displayDateTime = () => {
        const date = new Date(lastMessage.publication_date);
        const today = new Date();
        const diff = datetimeDifference(date, new Date());

        if (date.toLocaleDateString() == today.toLocaleDateString()) {
            return `${date.getHours() < 10 ? "0" : ""}${date.getHours()}H${date.getMinutes() < 10 ? "0" : ""}${date.getMinutes()}`;
        }

        if (!isNaN(date.getTime())) {
            return date.toLocaleDateString();
        }
    };

    useEffect(() => {
        window.addEventListener("storage", () => {
            setNotifsStorage(localStorage.getItem("notifications"));
        });
    }, []);

    return (
        <a data-turbo="false"
           href={`${endpoint.base}/messages/${room.uuid}`}
           id="message"
           className="flex md:flex-row flex-col py-6 px-12 border-b-8 border-dark-blue cursor-pointer">
            <div id="message-img"
                 className="flex items-center overflow-hidden border-8 border-dark-blue rounded-full content-center lg:min-w-[240px] lg:min-h-[240px] lg:max-w-[240px] lg:max-h-[240px] min-w-[120px] min-h-[120px] max-w-[120px] max-h-[120px] bg-gray-100 md:mr-12 mr-0 mb-4 md:mb-0">
                {imgAvailable ? (
                    <img src={`${endpoint.img}/users/user-${contact.id}-1.jpg?${performance.now()}`}
                         onError={() => setImgAvailable(false)}
                         className="object-cover"
                         alt="image d'utilisateur"/>
                ) : null}
            </div>
            <div id="message-content"
                 className="w-full relative">
                <div id="message-content-header"
                     className="flex lg:flex-row flex-col justify-between lg:my-4">
                    <h1 className="font-ChunkFive text-dark-blue lg:text-5xl text-2xl">
                        <span className="uppercase">{contact.last_name} </span>
                        <span className="capitalize">{contact.first_name}</span>
                    </h1>
                    <h3 className="font-ChunkFive text-dark-blue lg:text-3xl text-base">{displayDateTime()}</h3>
                </div>
                <h1 className="font-ChunkFive text-dark-blue lg:text-4xl text-xl lg:my-4 capitalize">{contact.cities ? contact.cities.name : null}</h1>
                <p className="text-black lg:text-3xl text-base line-clamp-4 lg:mt-0 mt-4">
                    {lastMessage.authorId != contact.id && lastMessage.content ? "Vous: " : null}
                    {lastMessage.content && lastMessage.type == "message" ? lastMessage.content : lastMessage.type == "appointment" ? "Demande de rendez-vous" :
                        lastMessage.type == "answered-appointment" ?
                            (JSON.parse(lastMessage.content).accepted ? "Rendez-vous accepté !" : "Rendez-vous refusé !") :
                            lastMessage.type == "image" ? "Une image a été envoyée" :
                                lastMessage.type == "pdf" ? "Un pdf a été envoyé" : "Aucun message envoyé"}
                </p>
                {Array.isArray(JSON.parse(notifsStorage)) && JSON.parse(notifsStorage).includes(room.uuid) ? (
                    <div className="absolute bottom-0 right-0 w-8 h-8 bg-blue-300 rounded-full animate-pulse"></div>
                ) : null}
            </div>
        </a>
    );
}
