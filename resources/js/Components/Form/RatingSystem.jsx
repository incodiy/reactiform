import React, { useState } from 'react';
import Rating from 'react-rating-stars-component';

/**
    $request->validate([
        'product_rating' => 'required|integer|min:1|max:5'
    ]);
 */
const RatingInput = ({ config }) => {
    const [rating, setRating] = useState(0);

    return (
        <div className="rating-system">
            {config.showLabel && <label>{config.label}</label>}
            
            <Rating
                count={config.max}
                value={rating}
                onChange={(value) => {
                    setRating(value);
                    document.getElementById(config.name).value = value;
                }}
                size={24}
                activeColor={config.color}
                isHalf={config.half}
                emptyIcon={<i className="far fa-star"></i>}
                filledIcon={<i className="fa fa-star"></i>}
            />
            
            <input type="hidden" id={config.name} name={config.name} value={rating} />
        </div>
    );
};

export default RatingInput;
// This component uses the react-rating-stars-component library to create a star rating system.