import React, { useState, useEffect } from 'react'
import BubbleMessage from './BubbleMessage'
import axios from 'axios';

export default function LoadingChatRoom({user, contact, room}) {
    const [messages, setMessages] = useState([]);
    useEffect(() => {
        axios.get(`/ajax/messages/${room}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => setMessages(response.data))
        .catch(e => console.error(e));
    }, [])
    
  return (
    <>
        {messages.map((e, i) => {
            e.shape = true;
            if (messages[i+1] != undefined) {
                if (e.authorId == messages[i+1].authorId) {
                    const dateCurrentMessage = new Date(e.publication_date).setSeconds(0,0);
                    const dateNextMessage = new Date(messages[i+1].publication_date).setSeconds(0,0);
                    if (dateCurrentMessage == dateNextMessage) {
                        e.shape = false;
                    }
                }
            }
            return (
                <BubbleMessage content={e.content} publicationDate={e.publication_date} authorId={e.authorId} userId={user} shape={e.shape} key={e.id} />
            )
        })}
    </>
  )
}
