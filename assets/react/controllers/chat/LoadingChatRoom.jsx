import React, {useEffect, useState} from "react";
import BubbleMessage from "./BubbleMessage";
import axios from "axios";
import {EventSourcePolyfill} from "event-source-polyfill";
import { endpoint } from "../../../config";
import { Howl } from "howler";

export default function LoadingChatRoom({user, contact, room, jwtToken, urlMercure}) {
    const [messages, setMessages] = useState([]);
    const [initScroll, setInitScroll] = useState(false);

    useEffect(() => {
        // récupération des messages précédemment envoyés
        axios.get(`/ajax/messages/${room}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then(response => {
                setMessages(response.data);
            })
            .catch(e => console.error(e));

        // récupération des futurs messages envoyés
        const url = JSON.parse(urlMercure);
        const jwt = JSON.parse(jwtToken.replace(/\s/g, ""));

        const eventSource = new EventSourcePolyfill(url, {
            withCredentials: true,
            headers: {
                "Authorization": `Bearer ${jwt}`,
            },
            heartbeatTimeout: 120000,
        });

        eventSource.onmessage = event => {
            setMessages(prevMessages => [...prevMessages, JSON.parse(event.data)]);
        };
    }, []);

    useEffect(() => {
        if (messages.length > 0) {
            if (!initScroll) {
                scrollBottom();
                setInitScroll(true);
            } else {
                if (messages[messages.length - 1].authorId != user) {
                    const notification = new Howl({
                        src: [`${endpoint.audio}/message-pop.mp3`],
                        volume: 0.5,
                    });
                    notification.play();
                }
            }
        }
    }, [messages])

    function scrollBottom() {
        const sectionChat = document.querySelector("#section-chat");
        sectionChat.scrollTo(0, 999999999);
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
                                type={e.type}
                                room={room}
                                id={e.id}
                                key={e.authorId + e.publication_date + i}/>
                );
            })}
        </>
    );
}
