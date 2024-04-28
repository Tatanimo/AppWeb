import React, { useEffect, useState } from 'react'
import { endpoint } from '../../../config'
import axios from 'axios'

export default function InputChat({room, user}) {
    const [content, setContent] = useState("");

    const sendMessage = async (e) => {
        if (e.type == "click" || e.key == "Enter") {
            if (content != "") {
                const message = {
                    content: content,
                    author: user,
                    publication_date: new Date(),
                }
                await axios.post(`/ajax/messages/${room}`, {
                    message
                }, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then(response => {
                    setContent("");
                }).catch(e => console.error(e));
            }
        }
    }

  return (
    <>
        <button>
            <img src={`${endpoint.img}/icons/paper-clip.svg`} alt="icône d'ajout de fichier" />
        </button>
        <input type="text" value={content} className="w-3/4 rounded-full opacity-70 border-0 pl-10" onChange={(e) => {setContent(e.target.value)}} onKeyDown={(e) => {sendMessage(e)}} />
        <button>
            <img src={`${endpoint.img}/icons/send-fill.svg`} onClick={(e) => {sendMessage(e)}} alt="icône d'envoie du message" />
        </button>
    </>
  )
}
