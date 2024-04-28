import React from 'react'
import { endpoint } from '../../../config'

export default function Message() {
  return (
    <div id="message" className="flex py-6 px-12 first:border-y-8 border-dark-blue cursor-pointer">
        <div id="message-img" className="overflow-hidden min-w-80 content-center">
            <img src={`${endpoint.img}/users/test.jpg`} className="w-[240px] h-[240px] object-cover rounded-full border-8 border-dark-blue" alt="image d'utilisateur" />
        </div>
        <div id="message-content">
            <div id="message-content-header" className="flex justify-between my-4">
                <h1 className="font-ChunkFive text-dark-blue text-5xl">PIRROT Léna</h1>
                <h3 className="font-ChunkFive text-dark-blue text-3xl">10H34</h3>
            </div>
            <h1 className="font-ChunkFive text-dark-blue text-5xl my-4">Amiens</h1>
            <p className="text-black text-3xl">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In interdum iaculis lacus a dignissim. Donec convallis iaculis neque,</p>
        </div>
    </div>
  )
}
