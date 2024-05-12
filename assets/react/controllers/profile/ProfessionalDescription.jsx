import axios from 'axios';
import React, { useRef, useState } from 'react'
import ContentEditable from 'react-contenteditable';

function ProfessionalDescription({description, professionalId}) {
    const text = useRef(description);
    const [currentDesc, setCurrentDesc] = useState(description);

    const handleFocusLost = async () => {
        if (text.current != "" && text.current && text.current != currentDesc) {
            await axios.post(`/ajax/professional/desc/${professionalId}`, {
                description: text.current
            }, 
            {
                headers: {
                  'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => setCurrentDesc(text.current))
            .catch(error => console.error(error));
        }
    }

  return (
    <>
        <ContentEditable onBlur={handleFocusLost} className={`resize-none w-auto transition-colors text-xl px-1 py-2 border-none rounded-md hover:cursor-pointer focus:cursor-text hover:bg-gray-50 focus:bg-gray-100 focus:text-gray-600 focus:ring-0`} 
        html={text.current ? text.current : "Entrer une description"} 
        onChange={e => {
          text.current = e.target.value;
        }} />
    </>
  )
}

export default ProfessionalDescription