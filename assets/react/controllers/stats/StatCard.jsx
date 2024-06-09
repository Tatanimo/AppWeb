import React, {useEffect, useState} from "react";
import axios from "axios";

export default function StatCard({controller, endpoint, title}) {
  const [data, setData] = useState(0);
  useEffect(() => {
    let url = "";
    switch (controller) {
      case "google_analytics":
        url = "/admin/ajax/google/analytics/";
        break;
      case "users":
        url = "/ajax/";
        break;
    }
    axios.get(`${url}${endpoint}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    }).then(response => {
        setData(response.data);
    }).catch(error => console.error(error));
  }, []);
  

  return (
    <div className="border-2 border-gray-200 px-4 py-6 rounded-lg">
        <svg fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" className="text-indigo-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"></path>
        </svg>
        <h2 className="title-font font-medium text-3xl text-gray-900">{data}</h2>
        <p className="leading-relaxed">{title}</p>
    </div>
  )
}
