import React, {useEffect, useState} from "react";
import BubbleMessage from "./BubbleMessage";
import axios from "axios";
import {EventSourcePolyfill} from "event-source-polyfill";

export default function LoadingChatRoom({user, contact, room}) {
    const [messages, setMessages] = useState([]);

    useEffect(() => {
        // récupération des messages précédemment envoyés
        axios.get(`/ajax/messages/${room}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then(response => setMessages(response.data))
            .catch(e => console.error(e));

        // récupération des futurs messages envoyés
        const url = JSON.parse(document.getElementById("mercure-messages").textContent);
        const jwtInput = document.getElementById("jwt-messages");
        const jwt = JSON.parse(jwtInput.value.replace(/\s/g, ""));
        jwtInput.remove();

        const eventSource = new EventSourcePolyfill(url, {
            withCredentials: true,
            headers: {
                "Authorization": `Bearer ${jwt}`,
            },
        });

        eventSource.onmessage = event => {
            setMessages(prevMessages => [...prevMessages, JSON.parse(event.data)]);
        };
    }, []);

    function scrollBottom() {
        document.querySelector("#section-chat").scrollTo(0, 999999999);
    }

    const handleShape = () => {
        messages.map((e, i) => {
            e.shape = true;
            if (messages[i - 1] != undefined) {
                if (e.authorId == messages[i - 1].authorId) {
                    const dateCurrentMessage = new Date(e.publication_date).setSeconds(0, 0);
                    const datePrevMessage = new Date(messages[i - 1].publication_date).setSeconds(0, 0);
                    if (dateCurrentMessage == datePrevMessage) {
                        messages[i - 1].shape = false;
                    }
                }
            }
            return e;
        });
        return messages;
    };

    return (
        <>
            {handleShape().map((e, i) => {

                return (
                    <BubbleMessage content={e.content}
                                   publicationDate={e.publication_date}
                                   authorId={e.authorId}
                                   userId={user}
                                   shape={e.shape}
                                   key={e.authorId + e.publication_date + i}/>
                );
            })}
        </>
    );
}
