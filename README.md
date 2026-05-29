# Find My Car

**Find My Car** is a recommendation-first car discovery tool designed around a single hypothesis:

> Most car buyers don't know horsepower, torque, wheelbase, or transmission ratios. They know their budget, their family, how they drive, and what matters to them.

**Live demo:** [find-my-car-zg35.onrender.com](https://find-my-car-zg35.onrender.com/) *(free tier — first load may take ~30 s to cold-start)*


## What Did You Build and Why?

The problem statement was intentionally open-ended. Rather than building another filtering interface, I focused on the moment where buyers get stuck:

> "There are too many options and I don't know where to start."

Instead of presenting dozens of filters and comparison tables, the application asks users to complete a conversational sentence describing their needs.

**Example:**

> My budget is around ₹10–15 L, I mainly drive in the city, and I usually travel with my partner. I cover about 500–1,000 km/month, prefer a petrol car with manual gears, and what matters most to me is safety.

From these answers, the backend scores and ranks cars from the dataset and returns the top 3 recommendations with explanations and trade-offs.

**The Goal:**
The goal was not to help users compare cars. The goal was to help users create a shortlist.

---

## What Did You Deliberately Cut?

I did not build user accounts, detailed car pages, comparison tables, dealer integrations, live pricing, or chatbot functionality. While these could add value in a larger product, they would have taken time away from solving the main problem: helping a user decide what to buy.

* **Limited Recommendations:** I limited recommendations to three cars. Showing more options would simply recreate the same problem the user started with.
* **Raw User Reviews:** I deliberately chose not to show raw user reviews as part of the recommendation flow. While reviews contain valuable information, presenting dozens of individual opinions would add more information for users to process at the exact moment they're trying to make a decision. The goal of this MVP was to reduce cognitive load, not increase it. If I had more time, I would use AI to generate concise review summaries that surface common themes, strengths, and concerns from owner feedback, allowing users to benefit from reviews without having to read them all manually.

---

## What’s Your Tech Stack and Why Did You Pick It?

* **Laravel + React + Inertia.js:** I chose Laravel and React because they're the technologies I'm most productive with, which was important given the 2-3 hour time constraint. Laravel provides sensible defaults for routing, validation, database access, and application structure, allowing me to focus on solving the recommendation problem rather than framework setup. Inertia.js let me combine Laravel and React without building and maintaining a separate API layer, reducing complexity and development time.
* **PostgreSQL:** Render's free tier provides managed PostgreSQL out of the box, making it the simplest choice for deployment. PostgreSQL also supports JSONB, which was useful for storing flexible vehicle specification data.
* **Docker:** Docker was primarily used to simplify deployment on Render and ensure the application could be run consistently across environments with minimal setup.

---

## What Did You Delegate to AI Tools vs. Do Manually?

I used ChatGPT Codex as the primary builder throughout the project, with occasional use of GitHub Copilot and Antigravity. My role was product direction, review, and course-correction rather than writing code line by line.

**Where the Tools Helped Most:**
I delegated most implementation work to AI, including generating migrations, models, controllers, services, React components, database seeders, deployment configuration, Docker setup, and general application scaffolding. Once the architecture was established, AI was also responsible for implementing scoring calculations, and UI components.

**Manual Work & Workflow:**
A key part of my workflow was generating a complete end-to-end implementation first and then reviewing it as if it had been submitted by another engineer on my team. I manually reviewed every file in the codebase, identified issues, suggested improvements, and then used AI to make targeted changes. The final application went through multiple review and refinement cycles rather than being accepted in its initial generated form.

The parts I handled manually were the product decisions and overall direction of the project. I decided what experience to build, what features to cut, how the recommendation flow should work, what information to collect from users, how the scoring system should behave, and how the application should be structured. I also reviewed generated code, simplified solutions when necessary, fixed issues, and kept the scope aligned with the assignment.

**Where Did They Get in the Way?**
The biggest challenge was balancing engineering best practices with the realities of a 2-3 hour MVP. AI often defaulted to designing for a large-scale production system rather than the assignment's constraints.

A good example was the database design. Early suggestions introduced heavily normalized schemas with separate tables for makes, models, variants, specifications, specification definitions, score definitions, and multiple relationship tables. While these designs would make sense for a long-term automotive platform, they added complexity without improving the core recommendation experience I was trying to ship.

A significant part of the process was recognizing when a technically "correct" solution was actually the wrong solution for the problem at hand. I repeatedly simplified the architecture, ultimately favoring a smaller schema with JSONB specifications and precomputed scoring tables because it allowed me to deliver a working recommendation engine much faster.

---

## If You Had Another 4 Hours, What Would You Add?

* **Natural Language Input Mode:** Alongside the guided sentence flow, users could simply describe what they are looking for in their own words. For example: *"I have a budget of around 15 lakhs, mostly drive in the city, occasionally take road trips with my family, and safety is more important to me than performance."* An LLM would then extract structured preferences (budget, usage pattern, family size, fuel preference, priorities) to feed into the existing recommendation engine. This makes the experience feel more natural while keeping the deterministic matching logic already in place.
* **AI-Generated Recommendation Explanations:** The current system generates recommendations using a transparent scoring model and predefined reasons. I would use an LLM to convert those structured reasons into personalized explanations that clearly communicate why each car was recommended, what trade-offs were considered, and how the recommendation aligns with the user's stated needs.
* **AI-Generated Review Summaries:** Instead of asking users to read dozens of individual reviews, the system would analyze all available reviews and present a short summary highlighting common praise, recurring complaints, and overall owner sentiment. This helps users quickly understand real owner feedback without manually sifting through large amounts of data.

These additions would make the experience significantly more conversational and AI-native while keeping the recommendation engine itself deterministic, explainable, and easy to validate.
