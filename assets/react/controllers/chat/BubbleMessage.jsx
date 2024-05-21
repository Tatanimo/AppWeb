import React, {useEffect, useState} from "react";
import {endpoint} from "../../../config";

export default function BubbleMessage({content, publicationDate, authorId, userId, shape, type}) {
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

    const bubbleContent = () => {
        switch(type){
            case "appointment":
                const appointment = JSON.parse(content);
                return(
                    <div id="appointment-card" className="bg-white p-4 w-fit">
                        <h4 className="font-bold text-xl">Demande de rendez-vous</h4>
                        <br />
                        {appointment.animals.map(animal => {
                            return(
                                <div className="flex justify-between">
                                    <p className="font-bold mr-2">Animal:</p>
                                    <p>{animal.fk_category.name} ({animal.race}) - {animal.name}</p>
                                </div>
                            )
                        })}
                        <div className="flex justify-between">
                            <p className="font-bold mr-2">Date de rendez-vous:</p>
                            <p>{new Date(appointment.date[0]).toLocaleDateString()} - {new Date(appointment.date[1]).toLocaleDateString()}</p>
                        </div>
                        <div className="flex justify-between">
                            <p className="font-bold mr-2">Prix:</p>
                            <p>{appointment.price}€</p>
                        </div>
                        <br />
                        <hr />
                        <div className="flex justify-end mt-3">
                            <button type="button" className="mr-2">Refuser</button>
                            <button type="button">Accepter</button>
                        </div>
                    </div>
                );
            case "message":
            default:
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
    }
    
    return (
        bubbleContent()
    );
}
