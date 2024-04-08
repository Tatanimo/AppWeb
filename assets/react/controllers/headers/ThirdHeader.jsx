import React from "react";

export default function ThirdHeader({content, color, className}) {
    return (
        <h3 className={`font-ChunkFive uppercase pb-5 text-4xl ${className}
        ${color === "white" ? "text-white" : ""} 
        ${color === "black" ? "text-black" : ""}`}>
            {content}
        </h3>
    );
}