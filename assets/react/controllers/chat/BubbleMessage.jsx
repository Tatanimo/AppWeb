import React, {useEffect, useState} from "react";
import {endpoint} from "../../../config";
import Appointment from "./Appointment";

export default function BubbleMessage({content, publicationDate, authorId, userId, shape, type, id, room}) {
    const [classNameP, setClassNameP] = useState("bg-blue-dark-purple");
    const [classNameDiv, setClassNameDiv] = useState("");
    const [classNameShape, setClassNameShape] = useState("");
    const [imgAvailable, setImgAvailable] = useState(true);
    const [contentState, setContentState] = useState(content);

    useEffect(() => {
        if (authorId == userId) {
            setClassNameP("bg-turquoise");
            setClassNameDiv("justify-end");
        }

        if (shape) {
            if (authorId == userId) {
                setClassNameShape("rounded-br-none before:block before:absolute before:bg-chat-shape-turquoise before:bottom-0 before:right-[-46px] before:outline-turquoise before:outline-b-8 before:w-[50px] before:h-[32px]");
            } else {
                setClassNameShape("rounded-bl-none before:block before:absolute before:bg-chat-shape-blue before:bottom-0 before:left-[-46px] before:outline-blue-dark-purple before:outline-b-8 before:w-[50px] before:h-[32px]");
            }
        }
    }, []);

    const bubbleContent = () => {
        return (
            <div id={`message-bubble-${authorId}`}
                 className={`m-4 flex ${classNameDiv} px-24`}>
                {shape && authorId != userId ? (imgAvailable ? (
                    <img src={`${endpoint.img}/users/user-${authorId}-1.jpg`}
                         className="w-[64px] h-[64px] self-end object-cover rounded-full"
                         onError={() => setImgAvailable(false)}
                         alt="image d'utilisateur"/>
                ) : (
                    <div className="w-[64px] h-[64px] self-end rounded-full bg-gray-200"></div>
                )) : authorId != userId ? (
                    <div className="w-[64px]"></div>
                ) : null}
                {shape ? (
                        <p className={`${classNameP} relative max-w-[50%] rounded-[30px] w-fit ml-8 py-4 px-8 ${classNameShape}`}>
                            {type === "appointment" && <Appointment contentState={contentState}
                                                                    authorId={authorId}
                                                                    userId={userId}
                                                                    room={room}
                                                                    id={id}/>}
                            {type === "answered-appointment" &&
                                <h1 className="text-3xl font-ChunkFive">Rendez-vous accepté !</h1>}
                            {type === "message" && contentState}
                            {type === "image" && (
                                <img className="max-w-1/2 h-auto" src={`${endpoint.img}/messages/${authorId}-${id}.jpg`} />
                            )}
                            {type === "pdf" && (
                                <p>je suis un PDF</p>
                            )}
                        </p>)
                    : (
                        <p className={`${classNameP} relative max-w-[50%] rounded-[30px] w-fit ml-8 py-4 px-8`}>{contentState}</p>
                    )}
                {authorId == userId ? (
                    <div className="w-[64px]"></div>
                ) : null}
            </div>
        );
    };

    return (
        bubbleContent()
    );
}
