import React from "react";

export default function Paragraph({content, color, className}) {
    return (
        <p className={`${color === "white" ? "text-white" : ""} ${color === "black" ? "text-black" : ""} text-2xl ${className}`}>
            {content}
        </p>
    );
}