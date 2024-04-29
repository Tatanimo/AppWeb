import axios from 'axios';
import React, { useState } from 'react'
import ReactTextareaAutosize from 'react-textarea-autosize';

export default function Description({description, userId}) {
    const [desc, setDesc] = useState(description);
    const [currentDesc, setCurrentDesc] = useState(description);

    const handleFocusLost = async () => {
        if (desc != "" && desc && desc != currentDesc) {
            await axios.post(`/ajax/profile/${userId}`, {
                description: desc
            }, 
            {
                headers: {
                  'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => {setCurrentDesc(desc)})
            .catch(error => console.error(error));
        }
    }

  return (
    <>
        <h3 className="mx-6 font-ChunkFive px-4 text-4xl my-3">Description</h3>
        <ReactTextareaAutosize minRows={2} maxLength={250} type='text' suppressContentEditableWarning={true} onChange={(e) => setDesc(e.target.value)} onBlur={handleFocusLost} className={`resize-none w-auto transition-colors mx-6 text-2xl px-4 py-2 border-none rounded-md hover:cursor-pointer focus:cursor-text hover:bg-gray-50 focus:bg-gray-100 focus:text-gray-600 focus:ring-0`} placeholder='Entrer une description...' value={desc ? desc : ""}/>
    </>
  )
}
