<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import axios from 'axios';
import { Head, Link, useForm } from '@inertiajs/vue3';
import {ref} from "vue";

const props = defineProps({
    link: String,
    history: Array,
})

const form = useForm({});

const outcome = ref(null);
const randomNum = ref(null);
const prize = ref(null);
const parsedHistory = ref(null);

const play = async () => {
    try {
        const response = await axios.get(route('play', {
            'hash' : props.link,
        }));

        outcome.value = response.data.outcome;
        randomNum.value = response.data.random_number;
        prize.value = response.data.prize;

        parsedHistory.value = null;
    } catch (error) {
        console.error('Error fetching users:', error);
    }
};

const generateNewLink = () => {
    form.post(route('update', {
        'hash' : props.link,
    }));
};

const deactivateLink = () => {
    form.post(route('deactivate', {
        'hash' : props.link,
    }));
};

const getHistory = async () => {
    try {
        const response = await axios.get(route('getHistory', {
            'hash' : props.link,
        }));

        parsedHistory.value = response.data.history.map(item => JSON.parse(item));
    } catch (error) {
        console.error('Error fetching history:', error);
    }
};

</script>

<template>
    <div
        class="flex min-h-screen items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0"
    >
        <div
            class=" w-full overflow-hidden bg-white px-8 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <div class="container">
                <div class="column">
                    <form @submit.prevent="generateNewLink">
                        <PrimaryButton>Generate new link</PrimaryButton>
                    </form>
                </div>

                <div class="column">
                    <form @submit.prevent="deactivateLink">
                        <PrimaryButton>Deactivate link</PrimaryButton>
                    </form>
                </div>

                <div class="column">
                    <form @submit.prevent="play">
                        <PrimaryButton>I'm Feeling Lucky</PrimaryButton>
                    </form>
                </div>

                <div class="column">
                    <form @submit.prevent="getHistory">
                        <PrimaryButton>History</PrimaryButton>
                    </form>
                </div>

                <div v-if="parsedHistory" class="history-section">
                    <h3>History</h3>
                    <ul>
                        <li v-for="(entry, index) in parsedHistory" :key="index">
                            <p><strong>Outcome:</strong> {{ entry.outcome }}</p>
                            <p><strong>Prize:</strong> {{ entry.prize }}</p>
                            <p><strong>Random Number:</strong> {{ entry.random_number }}</p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="link-display">
                <div v-if="outcome">
                    <p>Result: {{ outcome }}</p>
                    <p>Random Number: {{ randomNum }}</p>
                    <p>Prize: {{ prize }}</p>
                </div>
            </div>
        </div>
    </div>

</template>
<style scoped>
    .container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        margin: 20px 0;
    }

    .column {
        flex: 1 1 200px;
        display: flex;
        justify-content: center;
    }

    .link-display {
        margin-top: 20px;
        text-align: center;
        font-size: 1.2em;
        color: #333;
    }

    .history-section {
        margin-top: 20px;
        padding: 10px;
        border: 1px solid #ddd;
        background-color: #f1f1f1;
    }

    .history-section h3 {
        margin-bottom: 10px;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        padding: 10px 0;
        border-bottom: 1px solid #eaeaea;
    }

    li:last-child {
        border-bottom: none;
    }
</style>
