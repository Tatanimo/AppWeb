import React from "react";

export default function FirstHeader({content, color, className}) {
    return (
        <h1 className={`font-ChunkFive uppercase pb-5 text-7xl ${className} text-${color}`}>
            {content}
        </h1>
    );
}