// Rewards data
const rewardsData = [
    {
        id: 1,
        title: '$10 Gift Card',
        description: 'Redeem for a $10 gift card at your favorite sports store',
        points: 1000,
        image: '/health-gamification/img/bg.jpg'
    },
    {
        id: 2,
        title: 'Premium Membership',
        description: '1 month of premium membership with exclusive features',
        points: 2000,
        image: 'https://via.placeholder.com/300x160'
    },
    {
        id: 3,
        title: 'Fitness Tracker',
        description: 'Discount coupon for a new fitness tracker',
        points: 5000,
        image: 'https://via.placeholder.com/300x160'
    },
    {
        id: 4,
        title: 'Workout Plan',
        description: 'Custom workout plan created by professional trainers',
        points: 1500,
        image: 'https://via.placeholder.com/300x160'
    },
    {
        id: 5,
        title: 'Nutrition Consultation',
        description: '30-minute nutrition consultation with a dietitian',
        points: 3000,
        image: 'https://via.placeholder.com/300x160'
    },
    {
        id: 6,
        title: 'Workout Gear',
        description: 'Branded workout t-shirt and water bottle',
        points: 1200,
        image: 'https://via.placeholder.com/300x160'
    }
];

// Initialize rewards page
document.addEventListener('DOMContentLoaded', function() {
    const rewardsContainer = document.getElementById('rewards-container');
    const userPointsElement = document.getElementById('rewards-points');

    if (rewardsContainer && userPointsElement) {
        // Get user points
        const userPoints = parseInt(userPointsElement.textContent.replace(',', ''));
        
        // Populate rewards
        populateRewards(rewardsContainer, rewardsData, userPoints);
    }
});

// Populate rewards with updated redeem button style
function populateRewards(container, rewards, userPoints) {
    rewards.forEach(reward => {
        const card = document.createElement('div');
        card.className = 'reward-card';
        
        // Check if user has enough points
        const canRedeem = userPoints >= reward.points;
        const btnClass = canRedeem ? 'redeem-btn' : 'redeem-btn disabled';
        const btnText = canRedeem ? 'Redeem' : 'Not Enough Points';

        card.innerHTML = `
            <div class="reward-image">
                <img src="${reward.image}" alt="${reward.title}">
            </div>
            <div class="reward-content">
                <h3>${reward.title}</h3>
                <p>${reward.description}</p>
                <div class="reward-footer">
                    <div class="reward-points">${reward.points.toLocaleString()} points</div>
                    <button class="${btnClass}" ${!canRedeem ? 'disabled' : ''}>${btnText}</button>
                </div>
            </div>
        `;

        // Add event listener if redeemable
        if (canRedeem) {
            const redeemButton = card.querySelector('.redeem-btn');
            redeemButton.addEventListener('click', function() {
                redeemReward(reward, userPoints);
            });
        }

        container.appendChild(card);
    });
}

// Function to handle reward redemption
function redeemReward(reward, userPoints) {
    if (userPoints >= reward.points) {
        alert(`You have successfully redeemed: ${reward.title}`);
        // Here you can add logic to update the backend and deduct points
    } else {
        alert('Not enough points to redeem this reward.');
    }
}
