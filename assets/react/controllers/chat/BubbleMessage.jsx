import React, {useEffect, useState} from "react";
import {endpoint} from "../../../config";
import axios from "axios";

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

    const answeredAppointment = async (appointment, answer) => {
        await axios.post("/ajax/appointments", appointment, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            }
        })
        .then(res => {
            appointment.answered = true;
            appointment.accepted = answer;
            updateMessage(appointment).then(
                setContentState(JSON.stringify(appointment))
            );
        })
        .catch(err => console.error(err));
    }

    const updateMessage = async (appointment) => {
        await axios.post(`/ajax/messages/update/${id}`, {appointment: appointment}, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            }
        })
        .then(res => addMessageAppointment(appointment))
        .catch(err => console.error(err));
    }
    
    const addMessageAppointment = async (appointment) => {
        await axios.post(`/ajax/messages/appointment/${room}`, {
            appointment: appointment, 
            type: "answered-appointment"
        }, {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        });
    }

    const bubbleContent = () => {
        switch(type){
            // Prise de RDV -> appointmentAnswered.accepted = true -> ACCEPTER ou appointmentAnswered.accepted = false -> REFUSER
            case "answered-appointment":
                const appointmentAnswered = JSON.parse(contentState);
                return(
                    <div id="appointment-card" className="bg-white p-4 w-fit m-6">
                        <h4 className="font-bold text-xl">Rendez-vous {appointmentAnswered.accepted ? ("accepté") : "refusé"}</h4>
                        <br />
                        {appointmentAnswered.animals.map(animal => {
                            return(
                                <div key={animal.id} className="flex justify-between">
                                    <p className="font-bold mr-2">Animal:</p>
                                    <p>{animal.fk_category.name} ({animal.race}) - {animal.name}</p>
                                </div>
                            )
                        })}
                        <div className="flex justify-between">
                            <p className="font-bold mr-2">Date de rendez-vous:</p>
                            <p>{new Date(appointmentAnswered.date[0]).toLocaleDateString()} - {new Date(appointmentAnswered.date[1]).toLocaleDateString()}</p>
                        </div>
                        <div className="flex justify-between">
                            <p className="font-bold mr-2">Prix:</p>
                            <p>{appointmentAnswered.price}€</p>
                        </div>
                    </div>
                );
            // Prise de RDV en cours de réponse
            case "appointment":
                const appointment = JSON.parse(contentState);
                return(
                    <div id="appointment-card" className="bg-white p-4 w-fit m-6">
                        <h4 className="font-bold text-xl">Demande de rendez-vous</h4>
                        <br />
                        {appointment.animals.map(animal => {
                            return(
                                <div key={animal.id} className="flex justify-between">
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
                        {authorId != userId && !appointment.answered ? (
                            <div className="flex justify-end mt-3">
                                <button onClick={() => answeredAppointment(appointment, false)} type="button" className="mr-2">Refuser</button>
                                <button onClick={() => answeredAppointment(appointment, true)} type="button">Accepter</button>
                            </div>
                        ) : null}
                    </div>
                );
            // Message simple
            case "message":
            default:
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
                                <p className={`${classNameP} relative max-w-[50%] rounded-[30px] w-fit ml-8 py-4 px-8 ${classNameShape}`}>{contentState}</p>)
                            : (
                                <p className={`${classNameP} relative max-w-[50%] rounded-[30px] w-fit ml-8 py-4 px-8`}>{contentState}</p>
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
