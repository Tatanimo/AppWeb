import React, {useEffect, useState} from "react";
import {endpoint} from "../../../config";

export default function BubbleMessage({content, publicationDate, authorId, userId, shape}) {
    const [classNameP, setClassNameP] = useState("bg-blue-dark-purple");
    const [classNameDiv, setClassNameDiv] = useState("");
    const [classNameShape, setClassNameShape] = useState("");

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
    
    return (
        <div id={`message-bubble-${authorId}`}
             className={`m-2 flex ${classNameDiv} px-24`}>
            {shape && authorId != userId ? (
                <img src={`${endpoint.img}/users/user-${authorId}-1.jpg`}
                     className="w-[64px] h-[64px] object-cover rounded-full"
                     alt="image d'utilisateur"/>
            ) : authorId != userId ? (
                <div className="w-[64px]"></div>
            ) : null}
            {shape ? (
                    <p className={`${classNameP} relative max-w-[50%] rounded-[30px] w-fit ml-8 py-4 px-8 ${classNameShape}`}>{content}</p>)
                : (
                    <p className={`${classNameP} relative max-w-[50%] rounded-[30px] w-fit ml-8 py-4 px-8`}>{content}</p>
                )}

            {authorId == userId ? (
                <div className="w-[64px]"></div>
            ) : null}
        </div>
    );
}
