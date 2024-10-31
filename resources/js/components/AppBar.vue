<template>
    <v-toolbar
        density="compact"
        class=" toolbar w-100"
        color="white"
        :order="order"
      
    >
    <v-btn icon="mdi mdi-menu" @click="toggleSidebar"></v-btn>
        <span dir="rtl" class="breadCrumbSub"> {{ subTitle }}</span> &nbsp; -
        &nbsp;
        <span dir="rtl" class="breadCrumbTitle"> {{ mainTitle }}</span>
        <v-spacer></v-spacer>

        <div class="icon-bar">
            <!-- Render the icons with button-like styling -->
            <div class="icon-wrapper">
                <svg
                    width="20"
                    height="20"
                    viewBox="0 0 16 16"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                >
                    <rect
                        width="16"
                        height="16"
                        fill="url(#pattern0_5826_4251)"
                    />
                    <defs>
                        <pattern
                            id="pattern0_5826_4251"
                            patternContentUnits="objectBoundingBox"
                            width="1"
                            height="1"
                        >
                            <use
                                xlink:href="#image0_5826_4251"
                                transform="scale(0.01)"
                            />
                        </pattern>
                        <image
                            id="image0_5826_4251"
                            width="100"
                            height="100"
                            xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAACXBIWXMAAAsTAAALEwEAmpwYAAADL0lEQVR4nO3dv05UQRTH8e8CESpjxMg+gVqjPoMmKr1/ooIvYBYRjAVWxkKQxAR8ANDSxATFUNDDO6gkaCUWYL9mklOQhXvZve7MPcv9fZJpd87M2TtzCbNnQEREREREREREpLr6gCvAXaABTBdot4D+iDGGzx4rGFvDxnbZxupWHVgAfgHNLrTPwECEOMNnfulSjD+BN8AIjtSAKeBvlwbZPNAmIsT7KEKc+8CkzUWphoAPEQbYtLYUIeZ3EeN9b3NSilrkZDRtze626cgxr5T1pExFHtgPYDhC3OEztyPHHpav5Bv4/jFB7QGbwHqH7SvwOvJGGeKfs746jW+zzbEn3egXcoL5DTwATnFyDQIPgd2ceZhPFUxfzqttSMYFquNiTlJ2Uu0lV3O+FeHJqJrxnPkIfzxGdydn3TzJy1Te8pW1p9wmgScZnYfNrqq2ynzbepHR+QbVtZExJ2GuolNCDlNCnFFCnFFCnFFCnFFCnFFCnFFCnFFCnFFCnFFCnCk1Ic8zOg//Tauq9Yw5CXMV3VhG5+HfrlU1lzEnN1N03m+H2FoPJLg6LJZY/YiDE6spTzYO2CG2ReBppNMhvWbYjhgt2tzEOHUpIiIiIiIiIiIiIiIiIiIiBU6e3AfeWv2o05pBztiPPMOc3Et54iT8GP5Ty5GXb8DZCiflHPC9ZU4+pioccD3jUNhLqutVxpxcS9H5s4zO16iutYw5mUnRuX4WfZhOvzujhDijhDijhDijhDijhDijhDijhDijhDijhDijhDhTakJUBNNZEcy8MrGhZGrVDJZdJjavkHIov101E2UXUu6zm2WOCmDXym9XxSUPpcaxa36yvhW7Vn77JC9fg/Zk/MmZh1BuI5mRNq5s2LfNrsh1FXNWriKWut1eUOS6iq02r6s4T2KTxwT1v227hy90eUwJanbnUq9deTQTOeZlSjRkdy7FGtxSj10KtlzmpWAHn5RGG+tqkTae+DW1aNsra5k6bqOft9e9bgxyNeLFkq31voq2HXsBSb6Bd/rEjNpf9A07RNZJmwVuRD6K2W/V3mYLxNewsY16uEhSRERERERERESEkvwDZNYrhwPCZysAAAAASUVORK5CYII="
                        />
                    </defs>
                </svg>
            </div>
            <div class="icon-wrapper">
                <svg
                    width="20"
                    height="20"
                    viewBox="0 0 16 16"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                >
                    <rect
                        width="16"
                        height="16"
                        fill="url(#pattern0_5826_727)"
                    />
                    <defs>
                        <pattern
                            id="pattern0_5826_727"
                            patternContentUnits="objectBoundingBox"
                            width="1"
                            height="1"
                        >
                            <use
                                xlink:href="#image0_5826_727"
                                transform="scale(0.01)"
                            />
                        </pattern>
                        <image
                            id="image0_5826_727"
                            width="100"
                            height="100"
                            xlink:href="data:image/png;base64,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"
                        />
                    </defs>
                </svg>
            </div>
            <div class="icon-wrapper">
                <!-- <BellIcon class="icon" /> -->
                <svg
                    width="20"
                    height="20"
                    viewBox="0 0 16 16"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                >
                    <rect
                        width="16"
                        height="16"
                        fill="url(#pattern0_5826_2941)"
                    />
                    <defs>
                        <pattern
                            id="pattern0_5826_2941"
                            patternContentUnits="objectBoundingBox"
                            width="1"
                            height="1"
                        >
                            <use
                                xlink:href="#image0_5826_2941"
                                transform="scale(0.01)"
                            />
                        </pattern>
                        <image
                            id="image0_5826_2941"
                            width="100"
                            height="100"
                            xlink:href="data:image/png;base64,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"
                        />
                    </defs>
                </svg>
            </div>
        </div>
        
       
    </v-toolbar>
</template>

<script setup>
import {useAuthRepository} from "@/store/AuthRepository"
const AuthRepository = useAuthRepository();

const toggleSidebar = () => {
    AuthRepository.toggleRail(); // This will update the store and trigger reactivity
};

defineProps(["mainTitle", "subTitle"]);

const order = 0;
</script>

<style scoped>
.icon-bar {
    display: flex;
    gap: 0.5rem; /* Space between the buttons */
}

.icon-wrapper {
    background-color: #112f531a; /* Light gray background */
    padding: 0.5rem; 
    border-radius: 0.5rem; /* Rounded corners */
    display: flex;
    justify-content: center;
    align-items: center;
}

.icon {
    width: 24px;
    height: 24px;
    color: #000; /* Black color for the icons */
}

</style>
