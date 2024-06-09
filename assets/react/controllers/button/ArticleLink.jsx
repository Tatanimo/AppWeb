import React from "react";

export default function ButtonLink({content, className, href}) {
    return (
        <a href={href ? `/blog/${href}` : "#"}
           className={`inline-block justify-center active:scale-95 hover:bg-blue-purple-hover transition text-white text-xl bg-blue-purple px-7 py-5 rounded-xl ${className}`}>{content}</a>
    );
}