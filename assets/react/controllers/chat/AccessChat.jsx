import axios from 'axios'
import React from 'react'
import { endpoint } from '../../../config';

export default function AccessChat({contactId, appointment}) {
    const accessing = async () => {
        await axios.post(`/ajax/messages`, {
            'contact': contactId,
            'appointment': appointment
        }, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then((response) => {
            window.location.replace(`${endpoint.base}/messages/${response.data}`);
        })
        .catch((err) => console.error(err)); 
    }

  return (
    <button className="border border-black" onClick={accessing}>contact</button>
  )
}
