import React, {useState} from "react";
import {endpoint} from "../../../config";
import axios from "axios";

export default function InputChat({room, user}) {
    const [content, setContent] = useState("");

    function scrollBottom() {
        document.querySelector("#section-chat").scrollTo(0, 999999999);
    }

    const sendMessage = async (e) => {
        if (e.type == "click" || e.key == "Enter") {
            if (content != "") {
                const message = {
                    content: content,
                    author: user,
                    publication_date: new Date(),
                };
                await axios.post(`/ajax/messages/${room}`, {
                    message,
                }, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                }).then(response => {
                    setContent("");
                }).catch(e => console.error(e)).finally(() => scrollBottom());
            }
        }
    };

    return (
        <>
            <button className="hover:bg-blue-purple-dark-hover rounded-full p-2 transition">
                <img src={`${endpoint.img}/icons/paper-clip.svg`}
                     alt="icône d'ajout de fichier"
                     className="w-[24px]"/>
            </button>
            <input id="input-chat"
                   type="text"
                   value={content}
                   className="w-2/4 rounded-full opacity-70 border-0 h-12 py-4 px-6"
                   onChange={(e) => {
                       setContent(e.target.value);
                   }}
                   onKeyDown={(e) => {
                       sendMessage(e);
                   }}/>
            <button className="hover:bg-blue-purple-dark-hover rounded-full p-2 transition">
                <img src={`${endpoint.img}/icons/send-fill.svg`}
                     onClick={(e) => {
                         sendMessage(e);
                     }}
                     alt="icône d'envoie du message"
                     className="w-[24px]"/>
            </button>
        </>
    );
}
