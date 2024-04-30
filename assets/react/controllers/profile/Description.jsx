import axios from 'axios';
import React, { useState, useRef } from 'react'
import ContentEditable from 'react-contenteditable';

export default function Description({description, userId}) {
    const text = useRef(description);
    const [currentDesc, setCurrentDesc] = useState(description);

    const handleFocusLost = async () => {
        if (text.current != "" && text.current && text.current != currentDesc) {
            await axios.post(`/ajax/profile/desc/${userId}`, {
                description: text.current
            }, 
            {
                headers: {
                  'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => {setCurrentDesc(text.current)})
            .catch(error => console.error(error));
        }
    }

  return (
    <>
        <h3 className="mx-6 font-ChunkFive px-4 text-4xl my-3">Description</h3>
        <ContentEditable onBlur={handleFocusLost} className={`resize-none w-auto transition-colors mx-6 text-2xl px-4 py-2 border-none rounded-md hover:cursor-pointer focus:cursor-text hover:bg-gray-50 focus:bg-gray-100 focus:text-gray-600 focus:ring-0`} 
        html={text.current ? text.current : ""} 
        onChange={e => {
          text.current = e.target.value;
        }} />
    </>
  )
}
