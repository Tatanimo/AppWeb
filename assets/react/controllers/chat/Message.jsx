import React, { useState } from 'react'
import { endpoint } from '../../../config'
import datetimeDifference from 'datetime-difference';

export default function Message({roomSerialize, contactSerialize, lastMessageSerialize}) {
  const room = JSON.parse(roomSerialize);
  const contact = JSON.parse(contactSerialize);
  const lastMessage = JSON.parse(lastMessageSerialize);
  const [imgAvailable, setImgAvailable] = useState(true);

  const displayDateTime = () => {
    const date = new Date(lastMessage.publication_date);
    const today = new Date();
    const diff = datetimeDifference(date, new Date());

    if(date.toLocaleDateString() == today.toLocaleDateString()) {
      return `${date.getHours() < 10 ? "0" : ""}${date.getHours()}H${date.getMinutes() < 10 ? '0' : ''}${date.getMinutes()}`;
    } 

    if (!isNaN(date.getTime())) {
      return date.toLocaleDateString();
    } 
    
  }

  return (
    <a href={`/messages/${room.uuid}`} id="message" className="flex py-6 px-12 border-b-8 border-dark-blue cursor-pointer">
        <div id="message-img" className="overflow-hidden border-8 border-dark-blue rounded-full content-center min-w-[240px] min-h-[240px] max-w-[240px] max-h-[240px] bg-gray-100 mr-12">
          {imgAvailable ? (
            <img src={`${endpoint.img}/users/user-${contact.id}-1.jpg`} onError={() => setImgAvailable(false)} className="object-cover" alt="image d'utilisateur" />
          ) : null}
        </div>
        <div id="message-content" className='w-full'>
            <div id="message-content-header" className="flex justify-between my-4">
                <h1 className="font-ChunkFive text-dark-blue text-5xl">
                  <span className='uppercase'>{contact.last_name}</span> <span className='capitalize'>{contact.first_name}</span>
                </h1>
                <h3 className="font-ChunkFive text-dark-blue text-3xl">{displayDateTime()}</h3>
            </div>
            <h1 className="font-ChunkFive text-dark-blue text-5xl my-4 capitalize">{contact.cities ? contact.cities.name : null}</h1>
              <p className="text-black text-3xl">
                {lastMessage.authorId != contact.id && lastMessage.content ? "Vous: " : null}
                {lastMessage.content ? lastMessage.content : "Aucun message envoyé"}
              </p>
        </div>
    </a>
  )
}
